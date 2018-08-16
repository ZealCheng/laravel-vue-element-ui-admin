<?php

Route::get('/', 'PublicController@home');

Route::get('login', 'LoginController@login')->name('admin.login');
Route::post('login', 'LoginController@login')->name('admin.login');
Route::post('logout', 'LoginController@logout');

//  获取前端菜单展示
Route::get('basic/getMenuList', 'MenuController@getMenuList');

//  获取前端路由菜单列表
Route::get('basic/getMenusListForVueRouter', 'MenuController@getMenusListForVueRouter');

//  获取菜单权限选择列表
Route::get('basic/getMenuPermissionList', 'MenuController@getMenuPermissionList');

//  根据角色编号获取当前角色已拥有的菜单权限
Route::get('basic/getMenuPermissionListByRoleId', 'MenuController@getMenuPermissionListByRoleId');

//  获取用户编号获取权限列表 编号为空则获取全部角色
Route::get('basic/getRoleListByUserId', 'RoleController@getRoleListByUserId');

//  检测权限
Route::post('basic/checkRolePermission', 'UserController@checkRolePermission');

//  'auth.admin:admin'
Route::group(['middleware' => ['auth.admin:admin']], function ($router) {
//    $router->get('/', ['middleware'=>'permission:systems.index', 'uses'=>'AdminController@index']);
    $router->get('/dash', function () {
        echo '你已经登陆';
    });

    //  管理员管理
    $router->get('/user', ['uses'=>'UserController@index']);
    $router->post('/user/remove', ['uses'=>'UserController@postRemove']);
    $router->post('/user/edit', ['uses'=>'UserController@postEdit']);
    $router->post('/user/add', ['uses'=>'UserController@postAdd']);

    //  菜单管理
    $router->get('/menu', ['uses'=>'MenuController@index']);
    $router->post('/menu/remove', ['uses'=>'MenuController@postRemove']);
    $router->post('/menu/edit', ['uses'=>'MenuController@postEdit']);
    $router->post('/menu/add', ['uses'=>'MenuController@postAdd']);

    //  角色管理
    $router->get('/role', ['uses'=>'RoleController@index']);
    $router->post('/role/remove', ['uses'=>'RoleController@postRemove']);
    $router->post('/role/edit', ['uses'=>'RoleController@postEdit']);
    $router->post('/role/add', ['uses'=>'RoleController@postAdd']);
});


