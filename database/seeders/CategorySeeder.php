<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'All about tech',
            ],
            [
                'name' => 'Science',
                'slug' => 'science',
                'description' => 'All about science',
            ],
            [
                'name' => 'Art',
                'slug' => 'art',
                'description' => 'All about art',
            ],
        ]);
    }
}
