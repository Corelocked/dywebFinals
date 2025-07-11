<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@db.com'],
            [
                'firstname' => 'Admin',
                'lastname' => 'Administrator',
                'image_path' => '/images/avatars/user.png',
                'password' => bcrypt('admin1234'),
            ]
        );

        $role = Role::firstOrCreate(['name' => 'Admin'], ['guard_name' => 'web']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
