<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 17-7-6
 * Time: 下午2:43
 */

namespace App\Repositories\Admin;


use App\Models\Admin\Menu;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleRepository extends AdminRepository implements InterAdminRepository
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Role();
    }

    /**
     *
     * @return mixed
     */
    public function getList()
    {
        return Role::orderBy('id','asc')->paginate(config('admin.systems.page_size', 20));
    }

    /**
     * 各个服务需实现自己的分页方法
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginateData(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Role::orderBy('id','asc')->paginate();
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
            if ($key == 'permissionList') {
                continue;
            }
            $this->model->$key = $value;
        }

        $re = $this->model->save();

        if (!$re) {
            DB::rollback();//事务回滚
            throw new \Exception("添加角色失败");
        }

        if (!$this->saveRolePermission($this->model, $params['permissionList'])) {
            DB::rollback();//事务回滚
            throw new \Exception("添加角色失败");
        }

        $this->msg = "添加角色成功";
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
            if ($key == 'updated_at' || $key == 'deleted_at' || $key == 'permissionList') {
                continue;
            }
            $model->$key = $value;
        }

        $re = $model->save();

        if (!$re) {
            DB::rollback();//事务回滚
            throw new \Exception("更新数据失败");
        }

        if (!$this->saveRolePermission($model, $params['permissionList'])) {
            DB::rollback();//事务回滚
            throw new \Exception("更新角色失败");
        }

        $this->msg = "更新数据成功";
        DB::commit();
        return true;
    }

    /**
     * 保存角色与权限之间的关系
     * @param Role $roleModel
     * @param $nameList
     * @return array
     */
    public function saveRolePermission(Role $roleModel, $nameList)
    {
        $permissionModel = new Permission();
        /*
        $menuModel = new Menu();
        $menuList = $menuModel->whereIn('slug', $nameList)->select(['id', 'slug', 'pid'])->get()->toArray();
        $nameList = [];
        $i = 0;
        foreach ($menuList as $value) {
            $list = [];
            $this->getMenuSlug($value, $list);
            foreach ($list as $name) {
                $nameList[$i] = $name;
                $i++;
            }
        }
        $nameList = array_unique($nameList);
        */

        $permissionIds = $permissionModel->whereIn('name', $nameList)->pluck('id')->toArray();

        return $roleModel->perms()->sync($permissionIds);
    }

    private function getMenuSlug(array $value = [], array &$list = [])
    {
        $menuModel = new Menu();
        $list[] = $value['slug'];
        if ($value['pid'] != 0) {
            $this->getMenuSlug($menuModel->where('id', $value['pid'])->select(['id', 'slug', 'pid'])->first()->toArray(), $list);
        }
    }

    /**
     * 获取用户编号获取权限列表 编号为空则获取全部角色
     * @param Request $request
     * @return array
     */
    public function getRoleListByUserId(Request $request)
    {
        $userId = $request->input('userId', 0);

        $roleIds = [];
        if (!empty($userId)) {
            $roleIds = DB::table('admin_role_user')->where('user_id', '=', $userId)->pluck('role_id')->toArray();
            $this->model->whereIn('id', $roleIds);
        }
        $result = $this->model->select(['id', 'name'])->get()->toArray();

        $list = [];
        foreach ($result as $key=>$value) {
            $value['check'] = in_array($value['id'], $roleIds) ? true : false;
//            $list[$value['id']] = $value['name'];
            $list[$key] = $value;
        }

        return $list;
    }
}