<?php

namespace App\Services\Translation;



interface TranslationServiceInterface
{
    public function create(array $data);
    public function update($id, array $data);
    public function show($id);
    public function search(array $filters, $filter);
}
