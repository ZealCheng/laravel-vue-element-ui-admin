<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 17-7-5
 * Time: 下午5:55
 */

namespace App\Repositories\Admin;
use App\Facades\AdminUserFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MenuRepository extends AdminRepository implements InterAdminRepository
{


    public function __construct()
    {
        parent::__construct();
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
       $request->session()->forget('admin_menu_list');
        if ($request->session()->has('admin_menu_list')) {
            return unserialize($request->session()->get('admin_menu_list'));
        }

        //  当前登录用户
        $user = AdminUserFacade::getCurrentLogonUserInfo();

        $permissions = $user->permissions;
        $menuList = [];
        if (! empty($permissions)) {
            foreach ($permissions as $k => $v) {
                if (empty($v->inherit_id)) {
                    $v->children = array();
                    foreach ($permissions as $val) {
                        if (! empty($val->inherit_id) && $v->id == $val->inherit_id) {
                            $v->children[] = $val;
                        }
                    }
                    $menuList[] = $v;
                }
            }
        }

        $request->session()->put('admin_menu_list', serialize($menuList));
        return $menuList;
    }

}