<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 17-8-25
 * Time: 下午4:46
 */

namespace App\Models\Admin;


use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $table = 'admin_permissions';
}