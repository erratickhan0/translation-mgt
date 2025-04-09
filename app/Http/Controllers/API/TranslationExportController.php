<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TranslationResource;
use App\Models\Locale\Translation;
use Illuminate\Http\Request;

class TranslationExportController extends Controller
{
    /**
     * Export all translations as JSON for frontend usage.
     */
    public function index(Request $request)
    {
        $start = $request->get('start', 0);
        $end = $request->get('end', 100000);

        if ($start < 0 || $end <= $start || ($end - $start) > 100000) {
            return response()->json(['message' => 'Invalid range provided. Max limit is 100000 records.'], 400);
        }

        $translations = Translation::select('id', 'key', 'value', 'tag_id', 'language_id')
            ->with([
                'tag:id',
                'language:id'
            ])
            ->skip($start)
            ->take($end - $start)
            ->get();

        return TranslationResource::collection($translations);
    }




}
