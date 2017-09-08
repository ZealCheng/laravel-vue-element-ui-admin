<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 17-8-25
 * Time: 下午4:44
 */

namespace App\Models\Admin;


use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table = 'admin_roles';

}