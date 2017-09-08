<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2017/8/26
 * Time: 上午11:38
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Menu extends Model
{
    use SoftDeletes;
    protected $table = 'admin_menus';
}