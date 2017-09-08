<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Menu;
class AdminMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefix = env('ADMIN_MODULE_PREFIX') ? env('ADMIN_MODULE_PREFIX') . '/' : '/';

        $index = new Menu();
        $index->name = "控制台";
        $index->group_name = "";
        $index->menu_type = 1;
        $index->pid = 0;
        $index->language = "zh";
        $index->hidden = '0';
        $index->component = 'Home';
        $index->icon = "fa fa-laptop";
        $index->slug = "admin-systems-index";
        $index->url = $prefix;
        $index->description = "控制台";
        $index->save();

        /**
         * 系统管理 []
         */

        $system = new Menu();
        $system->name = "系统管理";
        $index->group_name = "";
        $system->menu_type = 1;
        $system->pid = 0;
        $system->language = "zh";
        $system->hidden = '0';
        $system->component = 'Home';
        $system->icon = "fa el-icon-setting";
        $system->slug = "admin-systems-manage";
        $system->url = "{$prefix}user*, {$prefix}role*, {$prefix}permission*, {$prefix}menu*";
        $system->description = "系统管理";
        $system->save();

        $user = new Menu();
        $user->name = "用户管理";
        $user->group_name = "用户-角色-权限管理";
        $user->menu_type = 1;
        $user->pid = $system->id;
        $user->language = "zh";
        $user->hidden = '0';
        $user->component = 'AdminUser';
        $user->icon = "";
        $user->slug = "admin-users-list";
        $user->url = "{$prefix}user";
        $user->description = "显示用户管理";
        $user->save();

        $role = new Menu();
        $role->name = "角色管理";
        $role->group_name = "用户-角色-权限管理";
        $role->menu_type = 1;
        $role->pid = $system->id;
        $role->language = "zh";
        $role->hidden = '0';
        $role->component = 'Role';
        $role->icon = "";
        $role->slug = "admin-roles-list";
        $role->url = "{$prefix}role";
        $role->description = "显示角色管理";
        $role->save();

        $permission = new Menu();
        $permission->name = "权限管理";
        $permission->group_name = "用户-角色-权限管理";
        $permission->menu_type = 1;
        $permission->pid = $system->id;
        $permission->language = "zh";
        $permission->hidden = '0';
        $permission->component = 'Permission';
        $permission->icon = "";
        $permission->slug = "admin-permissions-list";
        $permission->url = "{$prefix}permission";
        $permission->description = "显示权限管理";
        $permission->save();

        $menu = new Menu();
        $menu->name = "菜单管理";
        $menu->group_name = "后台基础设置";
        $menu->menu_type = 1;
        $menu->pid = $system->id;
        $menu->language = "zh";
        $menu->hidden = '0';
        $menu->component = 'Menu';
        $menu->icon = "";
        $menu->slug = "admin-menus-list";
        $menu->url = "{$prefix}menu";
        $menu->description = "显示菜单管理";
        $menu->save();

        /**
         * 公共节点
         */
        $commonList = [
            ['name'=>'登陆', 'menu_type'=>2, 'pid'=>0, 'language'=>'zh', 'hidden'=>1, 'component'=>'Login', 'icon'=>'', 'slug'=>'', 'url'=>$prefix.'login', 'description'=>'登陆页面'],
            ['name'=>'404页面', 'menu_type'=>2, 'pid'=>0, 'language'=>'zh', 'hidden'=>1, 'component'=>'NotFound', 'icon'=>'', 'slug'=>'', 'url'=>$prefix.'404', 'description'=>'404页面']
        ];

        Menu::insert($commonList);
    }
}
