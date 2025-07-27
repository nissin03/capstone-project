<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $dirRole = Role::firstOrCreate(['name' => 'dir']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $dir = User::create([
            'name' => 'Director {$i}',
            'email' => "director@cvsu.edu.ph",
            'password' => Hash::make('password123?'),
        ]);

        $dir->assignRole($dirRole);

        for ($i = 1; $i <= 4; $i++) {
            $admin = User::create([
                'name' => 'Admin User {$i}',
                'email' => "admin{$i}@cvsu.edu.ph",
                'password' => Hash::make('password123?'),
            ]);

            $admin->assignRole($adminRole);
        }

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'User {$i}',
                'email' => "user{$i}@cvsu.edu.ph",
                'password' => Hash::make('password123?'),
            ]);

            $user->assignRole($userRole);
        }
    }
}
