<?php

namespace App\Console\Commands;

use App\Models\Locale\Language;
use App\Models\Locale\Tag;
use App\Models\Locale\Translation;
use Illuminate\Console\Command;
use Faker\Factory as Faker;

class PopulateTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:translations {count=100000}';


    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Populate the translations table with large datasets for testing scalability.';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count'); // The number of records to create, default 100k
        $targetRecords = $count; // The target number of records to insert
        $insertedRecords = 0; // To track the number of records inserted

        $fakerEn = Faker::create('en_US');
        $fakerFr = Faker::create('fr_FR');
        $fakerEs = Faker::create('es_ES');

        $languages = Language::all()->keyBy('slug'); // Ensure keys are 'en', 'fr', 'es'
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

        // Number of records per language/tag/key combination
        $recordsPerCombination = ceil($targetRecords / (count($languages) * count($tags) * count($keys)));

        $records = [];

        $this->info("Starting the seeding process for {$targetRecords} records...");

        // Loop through the keys and create records for each language/tag combination
        foreach ($keys as $keyIndex => $baseKey) {
            for ($i = 0; $i < $recordsPerCombination; $i++) {
                foreach (['en' => $fakerEn, 'fr' => $fakerFr, 'es' => $fakerEs] as $langSlug => $faker) {
                    foreach ($tags as $tag) {
                        $records[] = [
                            'language_id' => $languages[$langSlug]->id,
                            'tag_id'      => $tag->id,
                            'key'         => $baseKey . '_' . ($keyIndex * $recordsPerCombination + $i) . '_' . $tag->slug,
                            'value'       => $faker->realText(30),
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ];

                        $insertedRecords++;

                        // Insert every 1000 records
                        if (count($records) >= 1000) {
                            Translation::insert($records);
                            $this->info("Inserted {$insertedRecords} records...");
                            $records = []; // Reset records after insert
                        }

                        if ($insertedRecords >= $targetRecords) {
                            break 3; // Exit all loops once the target number of records is reached
                        }
                    }
                }
            }
        }

        // Ensure any remaining records are inserted if there are less than 1000 left
        if (!empty($records)) {
            Translation::insert($records);
            $insertedRecords += count($records);
            $this->info("Inserted remaining records...");
        }

        $this->info("Seeding completed. Total records inserted: {$insertedRecords}");
    }



}
