<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create([
            'role_name' => 'Admin',
        ]);
        Role::factory()->create([
            'role_name' => 'Contributor',
        ]);
        Role::factory()->create([
            'role_name' => 'Subscriber',
        ]);
    }
}
    