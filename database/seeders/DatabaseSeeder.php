<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed roles
        DB::table('roles')->insert([
            ['name' => 'Admin'],
            ['name' => 'Author'],
        ]);

        // Seed users
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role_id' => 1, // Admin
            ],
            [
                'name' => 'Author User',
                'email' => 'author@example.com',
                'password' => bcrypt('password'),
                'role_id' => 2, // Author
            ],
        ]);

        // Seed categories
        $this->call(CategorySeeder::class);
    }
}