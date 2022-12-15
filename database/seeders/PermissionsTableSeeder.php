<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $permissions = [
            // groups
            ['group' => 'groups', 'name' => 'view_groups', 'title' => 'View groups', 'guard_name' => 'web'],
            ['group' => 'groups', 'name' => 'add_group', 'title' => 'Add group', 'guard_name' => 'web'],
            ['group' => 'groups', 'name' => 'edit_group', 'title' => 'Edit group', 'guard_name' => 'web'],
            ['group' => 'groups', 'name' => 'delete_group', 'title' => 'Delete group', 'guard_name' => 'web'],

            // registration_pages
            ['group' => 'registration_pages', 'name' => 'view_registration_pages', 'title' => 'View registration pages', 'guard_name' => 'web'],
            ['group' => 'registration_pages', 'name' => 'add_registration_page', 'title' => 'Add registration page', 'guard_name' => 'web'],
            ['group' => 'registration_pages', 'name' => 'edit_registration_page', 'title' => 'Edit registration page', 'guard_name' => 'web'],
            ['group' => 'registration_pages', 'name' => 'delete_registration_page', 'title' => 'Delete registration page', 'guard_name' => 'web'],

            // tickets
            ['group' => 'tickets', 'name' => 'view_tickets', 'title' => 'View tickets', 'guard_name' => 'web'],
            ['group' => 'tickets', 'name' => 'add_ticket', 'title' => 'Add ticket', 'guard_name' => 'web'],
            ['group' => 'tickets', 'name' => 'edit_ticket', 'title' => 'Edit ticket', 'guard_name' => 'web'],
            ['group' => 'tickets', 'name' => 'delete_ticket', 'title' => 'Delete ticket', 'guard_name' => 'web'],

            // users
            ['group' => 'users', 'name' => 'view_users', 'title' => 'View users', 'guard_name' => 'web'],
            ['group' => 'users', 'name' => 'add_user', 'title' => 'Add user', 'guard_name' => 'web'],
            ['group' => 'users', 'name' => 'edit_user', 'title' => 'Edit user', 'guard_name' => 'web'],
            ['group' => 'users', 'name' => 'delete_user', 'title' => 'Delete user', 'guard_name' => 'web'],
        ];
        Permission::insert($permissions);
    }
}
