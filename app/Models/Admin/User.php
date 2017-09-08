<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 17-8-25
 * Time: 下午7:33
 */

namespace App\Models\Admin;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    protected $table = 'admin_users';
//    use SoftDeletes;
    use EntrustUserTrait; // add this trait to your user model
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}