<?php

namespace App\Http\Middleware;

use AdminMenu;
use Closure;

class AdminMenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->composer('*', function ($view) {
            //共享菜单数据
            $menus = AdminMenu::getMenusAllList();
            $view->with('menus', $menus);
        });
        return $next($request);
    }
}
