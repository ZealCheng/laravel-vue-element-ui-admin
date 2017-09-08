-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-09-08 11:25:10
-- 服务器版本： 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel-admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `exp_admin_menus`
--

DROP TABLE IF EXISTS `exp_admin_menus`;
CREATE TABLE `exp_admin_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '菜单关系',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '菜单名称',
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '分组名',
  `menu_type` int(11) NOT NULL DEFAULT '1' COMMENT '类型 1:导航菜单 2:普通按钮',
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'zh' COMMENT '语言包',
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `component` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'vue组建名称',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图标',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '菜单对应的权限',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '菜单链接地址',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `exp_admin_menus`
--

INSERT INTO `exp_admin_menus` (`id`, `pid`, `name`, `group_name`, `menu_type`, `language`, `hidden`, `component`, `icon`, `slug`, `url`, `description`, `sort`, `deleted_at`, `created_at`, `updated_at`) VALUES
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
(17, 6, '删除菜单', NULL, 2, 'zh', 0, NULL, NULL, 'admin-menus-remove', NULL, NULL, 3, NULL, '2017-09-07 18:43:54', '2017-09-07 18:58:48');

-- --------------------------------------------------------

--
-- 表的结构 `exp_admin_permissions`
--

DROP TABLE IF EXISTS `exp_admin_permissions`;
CREATE TABLE `exp_admin_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `exp_admin_permissions`
--

INSERT INTO `exp_admin_permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
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
(18, 'admin-menus-remove', '删除菜单', '', '2017-09-07 18:43:54', '2017-09-07 18:43:54');

-- --------------------------------------------------------

--
-- 表的结构 `exp_admin_permission_role`
--

DROP TABLE IF EXISTS `exp_admin_permission_role`;
CREATE TABLE `exp_admin_permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `exp_admin_permission_role`
--

INSERT INTO `exp_admin_permission_role` (`permission_id`, `role_id`) VALUES
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(8, 1),
(3, 2),
(4, 2),
(8, 2);

-- --------------------------------------------------------

--
-- 表的结构 `exp_admin_roles`
--

DROP TABLE IF EXISTS `exp_admin_roles`;
CREATE TABLE `exp_admin_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `exp_admin_roles`
--

INSERT INTO `exp_admin_roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'User Administrator', 'User is allowed to manage and edit other users', '2017-09-06 00:11:44', '2017-09-06 00:11:44'),
(2, 'owner', 'Project Owner', 'User is the owner of a given project', '2017-09-06 00:11:44', '2017-09-06 00:11:44');

-- --------------------------------------------------------

--
-- 表的结构 `exp_admin_role_user`
--

DROP TABLE IF EXISTS `exp_admin_role_user`;
CREATE TABLE `exp_admin_role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `exp_admin_role_user`
--

INSERT INTO `exp_admin_role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(3, 1),
(4, 1),
(1, 2),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- 表的结构 `exp_admin_users`
--

DROP TABLE IF EXISTS `exp_admin_users`;
CREATE TABLE `exp_admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `exp_admin_users`
--

INSERT INTO `exp_admin_users` (`id`, `name`, `email`, `password`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '冯炎', 'fengyan@mail.com', '$2y$10$kVJz4xJmciPrVzplrUNwyORC8peWg7Gbd.Xrj87a0Ey8wKk4XwneW', 'jqEoD4LRyp11Hk86csvDkBpolNseNFvfuk8qQQfe1i8sNjZuaRBfrP9BNc4F', NULL, '2017-09-06 00:11:45', '2017-09-06 00:11:45'),
(2, '火火', 'huohuo@mail.com', '$2y$10$/oJPzUyDF.PYUp8.cY3iwula6Ovnj5t4OQeaETFxwOIdEcc728nNy', 'HOHEEC6uhu5weS2Ntuly95eATWEx9mCsi6WHVewgIbvUzKwIPMQhQMdV6cPP', NULL, '2017-09-06 00:11:45', '2017-09-06 00:11:45'),
(3, 'test', 'test@18.com', 'test', NULL, NULL, '2017-09-06 02:58:14', '2017-09-06 02:58:14'),
(4, 'test', 'test@163.com', '123456', NULL, NULL, '2017-09-06 03:00:12', '2017-09-06 03:00:12');

-- --------------------------------------------------------

--
-- 表的结构 `exp_password_resets`
--

DROP TABLE IF EXISTS `exp_password_resets`;
CREATE TABLE `exp_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `exp_users`
--

DROP TABLE IF EXISTS `exp_users`;
CREATE TABLE `exp_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exp_admin_menus`
--
ALTER TABLE `exp_admin_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exp_admin_permissions`
--
ALTER TABLE `exp_admin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_permissions_name_unique` (`name`);

--
-- Indexes for table `exp_admin_permission_role`
--
ALTER TABLE `exp_admin_permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `admin_permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `exp_admin_roles`
--
ALTER TABLE `exp_admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_roles_name_unique` (`name`);

--
-- Indexes for table `exp_admin_role_user`
--
ALTER TABLE `exp_admin_role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `admin_role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `exp_admin_users`
--
ALTER TABLE `exp_admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_email_unique` (`email`);

--
-- Indexes for table `exp_password_resets`
--
ALTER TABLE `exp_password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `exp_users`
--
ALTER TABLE `exp_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `exp_admin_menus`
--
ALTER TABLE `exp_admin_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- 使用表AUTO_INCREMENT `exp_admin_permissions`
--
ALTER TABLE `exp_admin_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- 使用表AUTO_INCREMENT `exp_admin_roles`
--
ALTER TABLE `exp_admin_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `exp_admin_users`
--
ALTER TABLE `exp_admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `exp_users`
--
ALTER TABLE `exp_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 限制导出的表
--

--
-- 限制表 `exp_admin_permission_role`
--
ALTER TABLE `exp_admin_permission_role`
  ADD CONSTRAINT `admin_permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `exp_admin_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `exp_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `exp_admin_role_user`
--
ALTER TABLE `exp_admin_role_user`
  ADD CONSTRAINT `admin_role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `exp_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `exp_admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
