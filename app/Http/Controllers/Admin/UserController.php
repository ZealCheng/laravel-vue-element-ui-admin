<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2017/8/27
 * Time: 上午1:06
 */

namespace App\Http\Controllers\Admin;

use AdminUser;
use Illuminate\Http\Request;

class UserController extends AdminController
{
    protected $templetePrefix = 'admin.user.';

    /**
     * 每个继承admin控制器的方法需要声明该控制器的服务处理者
     * @return \App\Repositories\Admin\InterAdminRepository
     */
    public function getServiceRepositories(): \App\Repositories\Admin\InterAdminRepository
    {
        return AdminUser::getInstance();
    }

    /**
     * 批量检测用户权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkRolePermission(Request $request)
    {
        return $this->successForAjax('检测用户权限成功', $this->getServiceRepositories()->checkRolePermission($request));
    }
}