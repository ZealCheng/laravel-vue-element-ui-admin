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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取当前登录用户信息
     * @return mixed
     */
    public function getCurrentLogonUserInfo()
    {
        return auth()->guard('cas')->user();
    }

}