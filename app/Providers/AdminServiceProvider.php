<?php
/**
 * 后台基础管理服务注册
 * User: fengyan
 * Date: 2017/8/26
 * Time: 下午10:26
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('AdminMenu', function($app){
            return new \App\Repositories\Admin\MenuRepository();
        });

        $this->app->singleton('AdminRole', function ($app){
            return new \App\Repositories\Admin\RoleRepository();
        });

        $this->app->singleton('AdminUser', function ($app){
            return new \App\Repositories\Admin\UserRepository();
        });
    }
}