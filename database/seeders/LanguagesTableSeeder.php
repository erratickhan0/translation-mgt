<?php

namespace Database\Seeders;

use App\Models\Locale\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::insert([
            ['name' => 'English', 'slug' => 'en', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'French',  'slug' => 'fr', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Spanish', 'slug' => 'es', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
