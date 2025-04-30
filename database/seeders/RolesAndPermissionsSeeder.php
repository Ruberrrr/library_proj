<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $librarianRole = Role::firstOrCreate(['name' => 'librarian']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create permissions
        $reservationDeletePermission = Permission::firstOrCreate(['name' => 'reservation delete']);
        $reservationPermission = Permission::firstOrCreate(['name' => 'book reservation']);
        $giveBookPermission = Permission::firstOrCreate(['name' => 'give book']);
        $getBookPermission = Permission::firstOrCreate(['name' => 'get book']);
        $createBookPermission = Permission::firstOrCreate(['name' => 'edit book']);
        $deleteBookPermission = Permission::firstOrCreate(['name' => 'delete book']);
        $userAddPermission = Permission::firstOrCreate(['name' => 'add user']);
        $userDeletePermission = Permission::firstOrCreate(['name' => 'delete user']);
        $passwordUpdatePermission = Permission::firstOrCreate(['name' => 'update user password']);

        // Assign permissions to roles
        
        // Admim Permissions
        $adminRole->givePermissionTo($userAddPermission);
        $adminRole->givePermissionTo($userDeletePermission);
        $adminRole->givePermissionTo($createBookPermission);
        $adminRole->givePermissionTo($deleteBookPermission);
        $adminRole->givePermissionTo($passwordUpdatePermission);
        // Librarian Permissions
        $librarianRole->givePermissionTo($reservationDeletePermission);
        $librarianRole->givePermissionTo($giveBookPermission);
        $librarianRole->givePermissionTo($getBookPermission);
        $librarianRole->givePermissionTo($createBookPermission);
        $librarianRole->givePermissionTo($deleteBookPermission);
        // User Permissions
        $userRole->givePermissionTo($reservationPermission);
        $userRole->givePermissionTo($reservationDeletePermission);
    }
}    