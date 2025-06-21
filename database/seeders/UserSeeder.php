<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import the User model
use App\Models\Role; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSeeder extends Seeder
{
    use HasFactory;
    /**Run the database seeds.*/
  public function run(): void{User::factory(5)->create();

        $adminrole = Role::where('role_name', 'Admin')->first();
        $user = User::first();

        if ($adminrole && $user) {
            $user->roles()->attach($adminrole->id);
        }

        $nonAdminRoles = Role::where('role_name', '!=', 'Admin')->get();
        $nonAdminUsers = User::whereDoesntHave('roles', function ($query) {
            $query->where('role_name', 'Admin');
        })->get();

        {
            foreach ($nonAdminUsers as $nonAdminuser) {
                $randomRoles = $nonAdminRoles->random(rand(1, 2));
                $nonAdminuser->roles()->attach($randomRoles);
            }
        } 
    }
}