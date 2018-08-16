<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 17-7-5
 * Time: 下午5:55
 */

namespace App\Repositories\Admin;
use App\Facades\AdminUserFacade;
use App\Models\Admin\Menu;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MenuRepository extends AdminRepository implements InterAdminRepository
{

    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Menu();
    }

    /**
     * 获取全部导航列表
     * @param Request $request
     * @return array
     */
    public function getMenuNavList(Request $request)
    {
        /*
        if (Cache::has('menuList')) {
            return Cache::get('menuList');
        }
        Cache::forever('menuList', $list);
        */

        if ($request->session()->has('admin_menu_list')) {
            return unserialize($request->session()->get('admin_menu_list'));
        }

        //  当前登录用户
        $user = AdminUserFacade::getCurrentLogonUserInfo();

        $menuList = $this->getMenusList(null, 1, 0)->get();

        $list = [];
        foreach ($menuList as $key=>$value) {
            $list[$key]['id'] = $value->id;
            $list[$key]['path'] = $value->url;
            $list[$key]['component'] = $value->component;
            $list[$key]['name'] = $value->name;
            $list[$key]['pid'] = $value->pid;
            $list[$key]['hidden'] = (bool)$value->hidden;
            $list[$key]['iconCls'] = $value->icon;
            $list[$key]['leaf'] = false;
            $list[$key]['slug'] = $value->slug;
            $list[$key]['group_name'] = $value->group_name;
        }
        foreach ($list as $key=>$value) {
            $slug = $value['slug'];
            unset($value['slug']);
            //  超管不进行权限检测
            if (config('admin.systems.administrators', 0) == $user->id) {
                continue;
            }

            if (!$user->can($slug)) {
                unset($list[$key]);
            }
        }

        $list = array_values($list);

        $list = list_to_tree($list, 'id', 'pid', 'children');

        $menuList = [];
        foreach ($list as $key=>$value) {
            $menuList[$key] = $value;
            if (!isset($value['children'])) {
                continue;
            }
            $menuList[$key]['children'] = [];
            foreach ($value['children'] as $k => $val) {
                $menuList[$key]['children'][$val['group_name']][$k] = $val;
            }
        }

        $request->session()->put('admin_menu_list', serialize($menuList));
        return $menuList;
    }

    /**
     * 根据pid获取菜单列表模型
     * @param null $pid
     * @param null $menuType
     * @param null $hidden
     * @param array $filters    搜索字段
     * @return $this
     */
    public function getMenusList($pid = null, $menuType = null, $hidden= null, array $filters = [])
    {
        $model = Menu::where('language', config('app.locale'));

        if ($pid !== null) {
            $model->where('pid', $pid);
        }

        if ($menuType !== null) {
            $model->where('menu_type', $menuType);
        }

        if ($hidden !== null) {
            $model->where('hidden', $hidden);
        }

        if (isset($filters['name']) && !empty($filters['name'])) {
            $model->where('name', 'like','%'.$filters['name'].'%');
        }

        return $model->where('deleted_at', null)->orderBy('sort', 'asc')->orderBy('id','asc');
    }

    public function getMenusListForVueRouter()
    {
        $list = Menu::where('language', config('app.locale'))->where('menu_type', 1)->where('deleted_at', null)->orderBy('sort', 'asc')->orderBy('id','asc')->get();
        $menuList = [];
        foreach ($list as $key=>$value) {
            $menuList[$key]['id'] = $value->id;
            $menuList[$key]['path'] = $value->url;
            $menuList[$key]['component'] = $value->component;
            $menuList[$key]['name'] = $value->name;
            $menuList[$key]['pid'] = $value->pid;
            $menuList[$key]['hidden'] = (bool)$value->hidden;
            $menuList[$key]['iconCls'] = $value->icon;
            $menuList[$key]['leaf'] = false;
        }
        $menuList = list_to_tree($menuList, 'id', 'pid', 'children');

        foreach ($menuList as $key=>&$value) {
            if (empty($value['children']) && $value['hidden'] == false) {
                $value['children'] = [$value];
                $value['leaf'] = true;
            } else {
                foreach ($value['children'] as $val) {
                    unset($val['id']);
                    unset($val['pid']);
                }
            }
            unset($value['id']);
            unset($value['pid']);
        }

        return $menuList;
    }

    /**
     * 各个服务需实现自己的分页方法
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginateData(Request $request)
    {
        $pageSize   = $request->input('pageSize', config('admin.systems.page_size', 20));
        $pid        = $request->input('pid', null);
        $filters    = json_decode($request->input('filters', []), true);
        return $this->getMenusList($pid, null, null, $filters)->paginate($pageSize);
    }

    /**
     * 添加数据
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function add(Request $request)
    {
        DB::beginTransaction();
        $params = $request->input('params', []);

        foreach ($params as $key=>$value) {
            $this->model->$key = $value;
        }

        $re = $this->model->save();

        if (!$re) {
            DB::rollback();//事务回滚
            throw new \Exception("添加菜单失败");
        }

        if (empty($params['slug'])) {
            $this->msg = "添加数据成功";
            DB::commit();
            return true;
        }

        if (!$this->savePermission($params)) {
            DB::rollback();//事务回滚
            throw new \Exception("添加菜单失败");
        }

        $this->msg = "添加菜单成功";
        DB::commit();
        return true;

    }


    /**
     * 更新数据
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        DB::beginTransaction();
        $params = $request->input('params', []);

        $model = $this->model->find($params['id']);

        foreach ($params as $key=>$value) {
            if ($key == 'updated_at' || $key == 'deleted_at') {
                continue;
            }
            $model->$key = $value;
        }

        $re = $model->save();

        if (!$re) {
            DB::rollback();//事务回滚
            throw new \Exception("更新菜单失败");
        }
        if (!isset($params['slug']) || empty($params['slug'])) {
            $this->msg = "更新数据成功";
            DB::commit();
            return true;
        }

        if (!$this->savePermission($params)) {
            DB::rollback();//事务回滚
            throw new \Exception("更新菜单失败");
        }

        DB::commit();
        $this->msg = "更新菜单成功";
        return true;
    }

    /**
     * 保存权限信息
     * @param array $params
     * @return bool
     */
    protected function savePermission(array $params = [])
    {
        $permissionModel = new Permission();

        $permissionInfo = $permissionModel->where('name', $params['slug'])->first();
        if ($permissionInfo) {
            $permissionModel = $permissionInfo;
        }
        $permissionModel->name = get_value($params, 'slug', '');
        $permissionModel->display_name = get_value($params, 'name', '');
        $permissionModel->description = get_value($params, 'description', '');

        return $permissionModel->save();
    }

    /**
     * 根据id号批量删除
     * @param array $ids
     * @return mixed
     */
    public function removeByIds(array $ids = [])
    {
        $slugList = $this->model->whereIn('id', $ids)->pluck('slug')->toArray();

        $slugList = array_filter($slugList);
        $this->model->whereIn('id', $ids)->delete($ids);
        $permissionModel = new Permission();
        $permissionModel->whereIn('name', $slugList)->delete();

        return true;
    }

    /**
     * 获取菜单权限选择列表
     * @param Request $request
     * @return array
     */
    public function getMenuPermissionList(Request $request)
    {
        $menuList = $this->getMenusList(null, null, null)->where('slug', '<>', null)->select(['id', 'pid', 'name as display_name', 'slug as name'])->get()->toArray();

        return list_to_tree($menuList, 'id', 'pid', 'children');
    }

    /**
     * 根据角色编号获取当前角色已拥有的菜单权限
     * @param Request $request
     * @return array
     */
    public function getMenuPermissionListByRoleId(Request $request)
    {
        $permissionIdList = DB::table('admin_permission_role')->where('role_id', $request->input('roleId', 0))->pluck('permission_id')->toArray();

        if (empty($permissionIdList)) {
            return [];
        }

        $permissionNameList = DB::table('admin_permissions')->whereIn('id', $permissionIdList)->pluck('name')->toArray();

        if (empty($permissionNameList)) {
            return [];
        }

        $menuList = $this->getMenusList(null, null, null)->whereIn('slug', $permissionNameList)->select(['id', 'name as display_name', 'slug as name'])->get()->toArray();

        return $menuList;
    }
}