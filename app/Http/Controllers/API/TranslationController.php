<?php

namespace App\Http\Controllers\API;

use App\Filters\TranslationFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use App\Http\Resources\TranslationResource;
use App\Models\Locale\Translation;
use App\Services\Translation\TranslationServiceInterface;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    protected $translationService;

    public function __construct(TranslationServiceInterface $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Store a newly created translation in storage.
     */
    public function store(StoreTranslationRequest $request)
    {
        $translation = $this->translationService->create($request->validated());

        return new TranslationResource($translation);
    }

    /**
     * Display the specified translation.
     */
    public function show(Translation $translation)
    {
        $translation->load(['tag', 'language']);

        return new TranslationResource($translation);
    }

    /**
     * Update the specified translation in storage.
     */
    public function update(UpdateTranslationRequest $request, Translation $translation)
    {
        $updatedTranslation = $this->translationService->update($translation->id, $request->validated());

        return new TranslationResource($updatedTranslation);
    }

    /**
     * Search translations by tag, key, or content.
     */
    public function __invoke(Request $request, TranslationFilters $filter)
    {
        $filters = $request->only(['query', 'tag']);

        if (empty($filters)) {
            return response()->json(['message' => 'Query parameter is required.'], 400);
        }

        $translations = $this->translationService->search($filters,$filter);

        return TranslationResource::collection($translations);
    }

}
