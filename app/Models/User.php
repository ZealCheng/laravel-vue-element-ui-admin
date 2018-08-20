<?php
namespace App\Models;
/**
 * 分销/渠道 用户
 *
 * @author Leo Chen <leo.dev@qq.com>
 * @date 2018-04-04
 */

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
	protected $table   = 'users';
	protected $hidden  = ['created_at', 'deleted_at'];
	protected $guarded = [];
	protected $casts   = [];
}
