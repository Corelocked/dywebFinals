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
        $user = User::updateOrCreate(
            ['email' => 'writer@db.com'],
            [
                'firstname' => 'Cedric Joshua',
                'lastname' => 'Palapuz',
                'image_path' => '/images/avatars/user.png',
                'password' => bcrypt('writer1234'),
            ]
        );

        $role = Role::firstOrCreate(['name' => 'Writer'], ['guard_name' => 'web']);

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
