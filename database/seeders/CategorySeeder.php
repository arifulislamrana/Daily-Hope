<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Technology',
            'description' => 'Latest news in technology.',
        ]);

        Category::create([
            'name' => 'Health',
            'description' => 'Health tips and news.',
        ]);
    }
}
