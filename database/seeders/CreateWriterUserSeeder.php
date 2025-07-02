<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateWriterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'firstname' => 'Cedric Joshua',
            'lastname' => 'Palapuz',
            'email' => 'writer@db.com',
            'image_path' => '/images/avatars/user.png',
            'password' => bcrypt('writer1234'),
        ]);

        $role = Role::create(['name' => 'Writer']);

        $permissions = [
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'comment-edit',
            'image-list',
        ];

        $role->syncPermissions($permissions);

        $user->assignRole('Writer');
    }
}
