<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        //Permissions
        $permissions = Permission::all();
        
        //Assign permissions to roles
        $admin = Role::updateOrCreate([
            'name' => 'admin',
            'title' => 'Admin',
            'is_deleteable' => 0,
        ]);
        $admin->permissions()->sync($permissions);

        $user = Role::updateOrCreate([
            'name' => 'user',
            'title' => 'User'
        ]);
    }
}
