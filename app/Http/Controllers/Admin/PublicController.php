<?php
/**
 * 公共控制器
 * User: fengyan
 * Date: 2017/8/27
 * Time: 下午5:47
 */

namespace App\Http\Controllers\Admin;


use App\Facades\AdminUserFacade;
use Illuminate\Http\Request;

class PublicController extends AdminController
{
    /**
     * 后台主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return view($this->templetePrefix.'home');
    }

    /**
     * 每个继承admin控制器的方法需要声明该控制器的服务处理者
     * @return  \App\Repositories\Admin\InterAdminRepository;
     */
    protected function getServiceRepositories()
    {
        return \App\Repositories\Admin\InterAdminRepository;
        // TODO: Implement setServiceRepositories() method.
    }
}