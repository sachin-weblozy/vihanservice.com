<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // super admin 
        $superadmin_role = Role::create(['name' => 'superadmin']);
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@weblozy.com',
            'phone' => '9876543210',
            'password' => bcrypt('password')
        ]);
        $superadmin->assignRole($superadmin_role);

        // admin 
        $admin_role = Role::create(['name' => 'admin']);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@weblozy.com',
            'phone' => '9876543211',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole($admin_role);

        // technician 
        $technician_role = Role::create(['name' => 'technician']);
        $technician = User::create([
            'name' => 'Technician',
            'email' => 'technician@weblozy.com',
            'phone' => '9876543212',
            'password' => bcrypt('password')
        ]);
        $technician->assignRole($technician_role);

        // user/vendor 
        $user_role = Role::create(['name' => 'user']);
        $user = User::create([
            'name' => 'User',
            'email' => 'user@weblozy.com',
            'phone' => '9876543213',
            'password' => bcrypt('password')
        ]);
        $user->assignRole($user_role);




        // $role = Role::create(['name' => 'writer']);
        // $permission = Permission::create(['name' => 'edit articles']);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
