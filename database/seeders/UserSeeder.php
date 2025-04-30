<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // $user = User::create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('password'),
        // ]);

        // $adminRole = Role::firstOrCreate(['name' => 'admin']);
        // $user->assignRole($adminRole);

        $user = User::create([
            'name' => 'Librarian User',
            'email' => 'librarian@example.com',
            'password' => bcrypt('password'),
        ]);

        $librarianRole = Role::firstOrCreate(['name' => 'librarian']);
        $user->assignRole($librarianRole);
    }
}