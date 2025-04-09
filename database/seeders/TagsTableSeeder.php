<?php

namespace Database\Seeders;


use App\Models\Locale\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::insert([
            ['name' => 'Web',     'slug' => 'web',     'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mobile',  'slug' => 'mobile',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Desktop', 'slug' => 'desktop', 'created_at' => now(), 'updated_at' => now()],

         ]);
    }
}
