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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
        $this->username = 'username';

        $this->redirectTo = get_admin_url('index');
    }

    /**
     * 重写登录视图页面
     */
    public function login(Request $request)
    {
        if ($request->method() == 'POST') {
            $this->validateLogin($request);

            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            $outPut = ['code'=>0, 'msg'=>'', 'data'=>[]];

            if ($this->attemptLogin($request)) {
                $outPut['data']['userInfo'] = $this->guard()->user();

                if ($request->ajax()) {
                    return $this->successForAjax('登录成功', ['userInfo'=> $this->guard()->user()]);
                }
                return $this->sendLoginResponse($request);
            }

            if ($request->ajax()) {
                return $this->errorForAjax('登录失败');
            }
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }
        return view('admin.login.index');

    }

    /**
     * 自定义认证驱动
     * @return mixed
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
//        $request->session()->decrement('admin_menu_list')
//        $request->session()->invalidate();

        if ($request->ajax()) {
            return $this->successForAjax('退出成功');
        }

        return redirect('/');
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