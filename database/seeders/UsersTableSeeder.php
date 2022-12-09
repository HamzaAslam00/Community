<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin 
        $admin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@community.com',
            'password' => Hash::make('12345678'),
            'user_type' => 'admin',
        ]);
        $admin->assignRole('admin');
    }
}
