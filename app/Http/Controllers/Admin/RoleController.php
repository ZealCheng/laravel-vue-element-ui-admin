<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2017/9/4
 * Time: 下午9:51
 */

namespace App\Http\Controllers\Admin;

use AdminRole;
use Illuminate\Http\Request;

class RoleController  extends AdminController
{

    /**
     * 每个继承admin控制器的方法需要声明该控制器的服务处理者
     * @return \App\Repositories\Admin\InterAdminRepository
     */
    protected function getServiceRepositories(): \App\Repositories\Admin\InterAdminRepository
    {
        return AdminRole::getInstance();
    }

    /**
     * 获取用户编号获取权限列表 编号为空则获取全部角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoleListByUserId(Request $request)
    {
        return $this->successForAjax('获取角色列表成功' ,$this->getServiceRepositories()->getRoleListByUserId($request));
    }
}