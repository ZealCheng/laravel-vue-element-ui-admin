<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\AdminRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends AdminController
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('cas-auth.logout');
    }

    /**
     * ajax 获取分页数据
     * @return mixed
     */
    public function getAjaxPaginateData()
    {
        // TODO: Implement getAjaxPaginateData() method.
    }

    /**
     * 每个继承admin控制器的方法需要声明该控制器的服务处理者
     * @return \App\Repositories\Admin\InterAdminRepository
     */
    protected function getServiceRepositories()
    {
        return \App\Repositories\Admin\InterAdminRepository;
        // TODO: Implement setServiceRepositories() method.
    }
}