<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2017/8/27
 * Time: 上午1:36
 */

namespace App\Repositories\Admin;


use App\Helpers\My;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRepository extends AdminRepository implements InterAdminRepository
{
    protected $model;
    public function __construct()
    {
        parent::__construct();
        $this->model = new User();
    }

    /**
     * 各个服务需实现自己的分页方法
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginateData(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $pageSize = $request->input('pageSize', config('admin.systems.page_size', 20));

        $filters  = json_decode($request->input('filters', []), true);

        $model = new User();

        if (isset($filters['name']) && !empty($filters['name'])) {
            $model->where('name', 'like','%'.$filters['name'].'%');
        }

        return $model->orderBy('id','asc')->paginate($pageSize);
    }

    /**
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function add(Request $request)
    {
        $params = $request->input('params', []);

        if ($params['password'] != $params['rePassword']) {
            throw new \Exception("密码和重复密码不匹配");
        }
        unset($params['rePassword']);

        foreach ($params as $key=>$value) {
            if ($key == 'role' || $key == 'allRole') {
                continue;
            }
            $this->model->$key = $value;
        }

        $re = $this->model->save();
        if (!$re) {
            throw new \Exception("添加用户失败");
        }

        $this->saveUserRole($this->model, get_value($params,'role', []), get_value($params, 'allRole', []));

        $this->msg = "添加用户成功";

        return true;
    }


    public function edit(Request $request)
    {
        $params = $request->input('params', []);

        $model = $this->model->find($params['id']);

        $model->name = get_value($params, 'name');
        $model->id = get_value($params, 'id');
        $model->email = get_value($params, 'email');

        $re = $model->save();

        if (!$re) {
            throw new \Exception("更新用户失败");
        }

        $this->saveUserRole($model, get_value($params,'role', []), get_value($params, 'allRole', []));

        $this->msg = "更新用户成功";

        return true;
    }

    /**
     * 保存用户与角色之间的关系
     * @param User $model
     * @param array $roleList
     * @param array $allRoleList
     * @return bool
     */
    protected function saveUserRole(User $model, array $roleList = [], array $allRoleList = [])
    {
        $roleIds = [];

        foreach ($allRoleList as $key=>$item) {
            $roleIds[] = $item['id'];
        }

        $model->roles()->detach($roleIds);

        $model->roles()->attach($roleList);

        return true;
    }

    /**
     * 获取当前登录用户信息
     * @return mixed
     */
    public function getCurrentLogonUserInfo() : User
    {
        return auth()->guard('admin')->user();
    }


    /**
     * 批量检测用户权限
     * @param Request $request
     * @return array
     */
    public function checkRolePermission(Request $request)
    {
        $permissionList = $request->input('params.permissionList', []);

        $permissionModel = new Permission();
        $permissionNewList = $permissionModel->whereIn('name', $permissionList)->pluck('name')->toArray();
        $list = [];
        foreach ($permissionList as $name) {
            $list[$name] = 0;

            if ($this->getCurrentLogonUserInfo()->id == config('admin.systems.administrators', 0)) {
                $list[$name] = 1;
                continue;
            }

            //  当不存在该权限节点时候 则默认为true
            if (!in_array($name, $permissionNewList)) {
                $list[$name] = 1;
                continue;
            }
            //  验证用户是否有该权限
            if ($this->getCurrentLogonUserInfo()->can($name)) {
                $list[$name] = 1;
            }
        }
        return $list;
    }
}