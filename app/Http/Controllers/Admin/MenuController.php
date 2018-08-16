<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2017/9/3
 * Time: 上午11:30
 */

namespace App\Http\Controllers\Admin;

use AdminMenu;
use Illuminate\Http\Request;

class MenuController extends AdminController
{


    /**
     * 每个继承admin控制器的方法需要声明该控制器的服务处理者
     * @return \App\Repositories\Admin\InterAdminRepository
     */
    protected function getServiceRepositories()
    {
        return AdminMenu::getInstance();
    }

    /**
     * 获取路由菜单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenusListForVueRouter(Request $request)
    {
        return $this->successForAjax('获取路由菜单成功', $this->getServiceRepositories()->getMenusListForVueRouter());
    }

    /**
     * 获取菜单权限选择列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenuPermissionList(Request $request)
    {
        return $this->successForAjax('获取权限列表成功', $this->getServiceRepositories()->getMenuPermissionList($request));
    }

    public function getMenuPermissionListByRoleId(Request $request)
    {
        return $this->successForAjax('获取权限列表成功', $this->getServiceRepositories()->getMenuPermissionListByRoleId($request));
    }

    /**
     * 获取菜单导航列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenuList(Request $request)
    {
        return $this->successForAjax('获取导航菜单列表成功', $this->getServiceRepositories()->getMenuNavList($request));
    }
}