<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        $this->call(AdminPermissionTableSeeder::class);
//        $this->call(AdminRoleTableSeeder::class);
//        $this->call(AdminUserTableSeeder::class);
//        $this->call(AdminMenusTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        \Illuminate\Support\Facades\DB::select("
INSERT INTO `admin_menus` (`id`, `pid`, `name`, `group_name`, `menu_type`, `language`, `hidden`, `component`, `icon`, `slug`, `url`, `description`, `sort`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 0, '控制台', NULL, 1, 'zh', 0, 'Home', 'fa fa-laptop', 'admin-systems-index', '/', '控制台', 0, NULL, '2017-09-06 00:11:45', '2017-09-07 18:57:51'),
(2, 0, '系统管理', NULL, 1, 'zh', 0, 'Home', 'fa el-icon-setting', 'admin-systems-manage', '/user*, /role*, /permission*, /menu*', '系统管理', 0, NULL, '2017-09-06 00:11:45', '2017-09-06 00:11:45'),
(3, 2, '用户管理', '用户-角色-权限管理', 1, 'zh', 0, 'User', NULL, 'admin-users', '/user', NULL, 0, NULL, '2017-09-06 00:11:45', '2017-09-07 18:41:02'),
(4, 2, '角色管理', '用户-角色-权限管理', 1, 'zh', 0, 'Role', NULL, 'admin-roles-list', '/role', '显示角色管理', 0, NULL, '2017-09-06 00:11:45', '2017-09-06 00:14:35'),
(5, 2, '权限管理', '用户-角色-权限管理', 1, 'zh', 0, 'Permission', NULL, 'admin-permissions-list', '/permission', '显示权限管理', 0, '2017-09-06 03:00:40', '2017-09-06 00:11:45', '2017-09-06 03:00:40'),
(6, 2, '菜单管理', '后台基础设置', 1, 'zh', 0, 'Menu', NULL, 'admin-menus-list', '/menu', '显示菜单管理', 0, NULL, '2017-09-06 00:11:45', '2017-09-06 00:14:40'),
(7, 0, '登陆', NULL, 2, 'zh', 1, 'Login', NULL, NULL, '/login', '登陆页面', 0, NULL, NULL, '2017-09-06 00:14:25'),
(8, 0, '404页面', NULL, 2, 'zh', 1, 'NotFound', NULL, NULL, '/404', '404页面', 0, NULL, NULL, '2017-09-06 00:14:28'),
(9, 3, '添加用户', NULL, 2, 'zh', 1, NULL, NULL, 'admin-users-add', NULL, '添加用户操作', 1, NULL, '2017-09-07 18:30:06', '2017-09-07 18:40:50'),
(10, 3, '更新用户', NULL, 2, 'zh', 1, NULL, NULL, 'admin-users-edit', NULL, NULL, 2, NULL, '2017-09-07 18:38:20', '2017-09-07 18:38:29'),
(11, 3, '删除用户', NULL, 2, 'zh', 1, NULL, NULL, 'admin-users-remove', NULL, NULL, 3, NULL, '2017-09-07 18:40:38', '2017-09-07 18:40:38'),
(12, 4, '添加角色', NULL, 2, 'zh', 1, NULL, NULL, 'admin-roles-add', NULL, NULL, 1, NULL, '2017-09-07 18:41:46', '2017-09-07 18:42:36'),
(13, 4, '更新角色', NULL, 2, 'zh', 1, NULL, NULL, 'admin-roles-edit', NULL, NULL, 2, NULL, '2017-09-07 18:42:03', '2017-09-07 18:42:40'),
(14, 4, '删除角色', NULL, 2, 'zh', 1, NULL, NULL, 'admin-roles-remove', NULL, NULL, 3, NULL, '2017-09-07 18:42:29', '2017-09-07 18:42:29'),
(15, 6, '新增菜单', NULL, 2, 'zh', 1, NULL, NULL, 'admin-menus-add', NULL, NULL, 1, NULL, '2017-09-07 18:43:06', '2017-09-07 18:43:06'),
(16, 6, '更新菜单', NULL, 2, 'zh', 1, NULL, NULL, 'admin-menus-edit', NULL, NULL, 2, NULL, '2017-09-07 18:43:23', '2017-09-07 18:43:23'),
(17, 6, '删除菜单', NULL, 2, 'zh', 0, NULL, NULL, 'admin-menus-remove', NULL, NULL, 3, NULL, '2017-09-07 18:43:54', '2017-09-07 18:58:48');");

        \Illuminate\Support\Facades\DB::select("INSERT INTO `admin_permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'create-post', 'Create Posts', 'create new blog posts', '2017-09-06 00:11:44', '2017-09-06 00:11:44'),
(2, 'edit-user', 'Edit Users', 'edit existing users', '2017-09-06 00:11:44', '2017-09-06 00:11:44'),
(3, 'admin-systems-index', '控制台', '控制台', '2017-09-06 00:14:20', '2017-09-06 00:14:20'),
(4, 'admin-systems-manage', '系统管理', '系统管理', '2017-09-06 00:14:23', '2017-09-06 00:14:23'),
(5, 'admin-users-list', '用户管理', '显示用户管理', '2017-09-06 00:14:33', '2017-09-06 00:14:33'),
(6, 'admin-roles-list', '角色管理', '显示角色管理', '2017-09-06 00:14:35', '2017-09-06 00:14:35'),
(8, 'admin-menus-list', '菜单管理', '显示菜单管理', '2017-09-06 00:14:40', '2017-09-06 00:14:40'),
(9, 'admin-users-add', '添加用户', '添加用户操作', '2017-09-07 18:30:06', '2017-09-07 18:33:23'),
(10, 'admin-users-edit', '更新用户', '', '2017-09-07 18:34:25', '2017-09-07 18:34:25'),
(11, 'admin-users', '用户管理', '', '2017-09-07 18:35:48', '2017-09-07 18:35:48'),
(12, 'admin-users-remove', '删除用户', '', '2017-09-07 18:40:38', '2017-09-07 18:40:38'),
(13, 'admin-roles-add', '添加角色', '', '2017-09-07 18:41:46', '2017-09-07 18:41:46'),
(14, 'admin-roles-edit', '更新角色', '', '2017-09-07 18:42:03', '2017-09-07 18:42:03'),
(15, 'admin-roles-remove', '删除角色', '', '2017-09-07 18:42:29', '2017-09-07 18:42:29'),
(16, 'admin-menus-add', '新增菜单', '', '2017-09-07 18:43:06', '2017-09-07 18:43:06'),
(17, 'admin-menus-edit', '更新菜单', '', '2017-09-07 18:43:23', '2017-09-07 18:43:23'),
(18, 'admin-menus-remove', '删除菜单', '', '2017-09-07 18:43:54', '2017-09-07 18:43:54');");

        $this->call(AdminUserTableSeeder::class);

    }
}
