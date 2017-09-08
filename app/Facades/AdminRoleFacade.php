<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 17-7-6
 * Time: 下午2:53
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class AdminRoleFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(){
        return 'AdminRole';
    }
}