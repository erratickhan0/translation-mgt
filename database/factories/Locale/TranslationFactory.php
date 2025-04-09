<?php

namespace Database\Factories\Locale;

use App\Models\Locale\Language;
use App\Models\Locale\Tag;
use App\Models\Locale\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Translation>
 */
class TranslationFactory extends Factory
{
    protected $model = Translation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'language_id' => null,
            'tag_id' => null,
            'key' => null,
            'value' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
