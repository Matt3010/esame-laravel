<?php

use App\Http\Controllers\RichiestaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('tests')->group(function () {
    Route::get('/', [\App\Http\Controllers\TestController::class, 'getAllTests']);
});

Route::prefix('richieste')->group(function () {
    Route::get('/api1', [RichiestaController::class, 'getRichiesteDiFinanziamento']);
    Route::get('/api2', [RichiestaController::class, 'getRichiesteDiFinanziamentoFilteredByCognomeNomeRichiedente']);
    Route::post('/api3', [RichiestaController::class, 'postNuovaRichiestaFinanziamento']);
    Route::post('/api4/{richiestaID}', [RichiestaController::class, 'postModificaRichiestaFinanziamento']);
    Route::post('/api5/{richiestaID}', [RichiestaController::class, 'postDeleteRichiestaFinanziamento']);
    Route::post('/api6', [RichiestaController::class, 'getRichiesteDiFinanziamentoDatesRange']);
    Route::post('/api7', [RichiestaController::class, 'sommaImportiRichieste']);
    Route::post('/api8', [RichiestaController::class, 'mediaRateRichieste']);
});