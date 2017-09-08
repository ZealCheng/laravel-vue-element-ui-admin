<?php

use Illuminate\Database\Seeder;

class AdminRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\Models\Admin\Role();
        $admin->name = 'admin';
        $admin->display_name = 'User Administrator';
        $admin->description = 'User is allowed to manage and edit other users';
        $admin->save();

        $owner = new \App\Models\Admin\Role();
        $owner->name = 'owner';
        $owner->display_name = 'Project Owner';
        $owner->description = 'User is the owner of a given project';
        $owner->save();

        $createPost = \App\Models\Admin\Permission::where('name', '=', 'create-post')->first();
        $editUser = \App\Models\Admin\Permission::where('name', '=', 'edit-user')->first();
        $admin->attachPermissions([$createPost, $editUser]);

        $owner->attachPermission($createPost);
    }
}
