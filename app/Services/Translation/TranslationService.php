<?php

namespace App\Services\Translation;


use App\Models\Locale\Translation;



class TranslationService implements TranslationServiceInterface
{
    public function create(array $data)
    {
        return Translation::create($data);
    }

    public function update($id, array $data)
    {
        $translation = Translation::findOrFail($id);
        $translation->update($data);
        return $translation;
    }


    public function show($id)
    {
        return Translation::with(['tag', 'language'])->findOrFail($id);
    }

    public function search(array $filters, $filter): \Illuminate\Support\Collection
    {
        return $filter
            ->apply(
                Translation::select('id', 'key', 'value', 'tag_id', 'language_id')
                    ->with(['tag:id', 'language:id']),
                $filters
            )
            ->get();
    }


}
