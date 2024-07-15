<?php

use App\Http\Controllers\OffertaDiLavoroController;
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
    Route::get('/api1/{maxRichieste?}', [RichiestaController::class, 'getRichiesteDiFinanziamento']);
    Route::get('/api2/{CognomeNomeRichiedente?}', [RichiestaController::class, 'getRichiesteDiFinanziamentoFilteredByCognomeNomeRichiedente']);
    Route::post('/api3', [RichiestaController::class, 'postNuovaRichiestaFinanziamento']);
    Route::post('/api4/{richiestaID}', [RichiestaController::class, 'postModificaRichiestaFinanziamento']);
    Route::post('/api5', [RichiestaController::class, 'postDeleteRichiestaFinanziamento']);
    Route::post('/api6', [RichiestaController::class, 'getRichiesteDiFinanziamentoDatesRange']);
    Route::post('/api7', [RichiestaController::class, 'sommaImportiRichieste']);
    Route::post('/api8', [RichiestaController::class, 'mediaRateRichieste']);
});

Route::prefix('offerte')->group(function () {
    Route::post('/api1/', [OffertaDiLavoroController::class, 'api1Esame']);
    Route::post('/api2/', [OffertaDiLavoroController::class, 'api2Esame']);
    Route::post('/api3/', [OffertaDiLavoroController::class, 'api3Esame']);
    Route::delete('/api4/{offertaLavoroID}', [OffertaDiLavoroController::class, 'api4Esame']);
    Route::post('/api5/', [OffertaDiLavoroController::class, 'api5Esame']);
});