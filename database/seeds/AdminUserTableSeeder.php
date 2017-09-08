<?php

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  创建用户
        $admin = \App\Models\Admin\User::create([
            'name' => '冯炎',
            'email' => 'fengyan@mail.com',
            'password' => bcrypt('123456')
        ]);

        $owner = \App\Models\Admin\User::create([
            'name' => '火火',
            'email' => 'huohuo@mail.com',
            'password' => bcrypt('123456')
        ]);

        //  把权限分配给用户
//        $adminRole = \App\Models\Admin\Role::where('name', '=', 'admin')->first();
//        $admin->attachRole($adminRole);

//        $ownerRole = \App\Models\Admin\Role::where('name', '=', 'owner')->first();
//        $owner->attachRole($ownerRole);

    }
}
