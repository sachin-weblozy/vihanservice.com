<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = Role::where(['name' => 'superadmin'])->first();

        $permission = Permission::create(['name' => 'Permission Read']);
        $permission = Permission::create(['name' => 'Permission Create']);
        $permission = Permission::create(['name' => 'Permission Edit']);
        $permission = Permission::create(['name' => 'Permission Delete']);

        $permission = Permission::create(['name' => 'Role Read']);
        $permission = Permission::create(['name' => 'Role Create']);
        $permission = Permission::create(['name' => 'Role Edit']);
        $permission = Permission::create(['name' => 'Role Delete']);

        $permission = Permission::create(['name' => 'User Read']);
        $permission = Permission::create(['name' => 'User Create']);
        $permission = Permission::create(['name' => 'User Edit']);
        $permission = Permission::create(['name' => 'User Delete']);

        $permission = Permission::create(['name' => 'Ticket Read']);
        $permission = Permission::create(['name' => 'Ticket Create']);
        $permission = Permission::create(['name' => 'Ticket Edit']);
        $permission = Permission::create(['name' => 'Ticket Delete']);
        $permission = Permission::create(['name' => 'Ticket Assign']);
        $permission = Permission::create(['name' => 'Ticket Comment']);

        $permission = Permission::create(['name' => 'Category Read']);
        $permission = Permission::create(['name' => 'Category Create']);
        $permission = Permission::create(['name' => 'Category Edit']);
        $permission = Permission::create(['name' => 'Category Delete']);

        $permission = Permission::create(['name' => 'FAQ Read']);
        $permission = Permission::create(['name' => 'FAQ Create']);
        $permission = Permission::create(['name' => 'FAQ Edit']);
        $permission = Permission::create(['name' => 'FAQ Delete']);

        $permission = Permission::create(['name' => 'File Read']);
        $permission = Permission::create(['name' => 'File Create']);
        $permission = Permission::create(['name' => 'File Edit']);
        $permission = Permission::create(['name' => 'File Delete']);

        $permission = Permission::create(['name' => 'Video Read']);
        $permission = Permission::create(['name' => 'Video Create']);
        $permission = Permission::create(['name' => 'Video Edit']);
        $permission = Permission::create(['name' => 'Video Delete']);

        $admin_role->givePermissionTo(Permission::all());
    }
}
