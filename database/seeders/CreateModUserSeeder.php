<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateModUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'firstname' => 'Mod',
            'lastname' => 'Moderator',
            'email' => 'mod@db.com',
            'image_path' => '/images/avatars/user.png',
            'password' => bcrypt('mod1234'),
        ]);

        $role = Role::create(['name' => 'Moderator']);

        $permissions = [
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'post-highlight',
            'post-super-list',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'comment-list',
            'comment-edit',
            'comment-delete',
            'comment-super-list',
            'image-list',
            'image-delete',
        ];

        $role->syncPermissions($permissions);

        $user->assignRole('Moderator');
    }
}
