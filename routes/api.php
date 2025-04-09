<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TranslationController;
use App\Http\Controllers\API\TranslationExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);

    Route::get('translations/search', [TranslationController::class, '__invoke'])->name('translations.search');
    Route::get('translations/export', [TranslationExportController::class, 'index'])->name('translations.export');
    Route::resource('translations', TranslationController::class)->only(['store', 'update', 'show']);
});
