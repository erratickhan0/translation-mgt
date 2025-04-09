<?php

namespace Database\Seeders;

use App\Models\Locale\Language;
use App\Models\Locale\Tag;
use App\Models\Locale\Translation;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakerEn = Faker::create('en_US');
        $fakerFr = Faker::create('fr_FR');
        $fakerEs = Faker::create('es_ES');

        $languages = Language::all()->keyBy('slug');
        $tags = Tag::all();

        $keys = [
            'welcome_text',
            'signup_button',
            'error_message',
            'logout_link',
            'profile_heading',
            'submit_form',
            'dashboard_title',
            'search_placeholder',
            'no_results_text',
            'help_text'
        ];

        $records = [];
        $loopCount = 10000;

        for ($i = 0; $i < $loopCount; $i++) {
            $baseKey = $keys[$i % count($keys)] . '_' . $i;

            foreach (['en' => $fakerEn, 'fr' => $fakerFr, 'es' => $fakerEs] as $langSlug => $faker) {
                foreach ($tags as $tag) {
                    $records[] = [
                        'language_id' => $languages[$langSlug]->id,
                        'tag_id'      => $tag->id,
                        'key'         => $baseKey . '_' . $tag->slug,
                        'value'       => $faker->realText(30),
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }

                if (count($records) >= 1000) {
                    Translation::insert($records);
                    $records = [];
                }
            }
        }

        if (!empty($records)) {
            Translation::insert($records);
        }
    }

}
