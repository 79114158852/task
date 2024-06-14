<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\API\v1\Controllers\CityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => [
        'auth:sanctum'
    ],
    'prefix' => 'v1',
], function () {
    Route::prefix('/city')->group(function(){
        Route::post('/add', [CityController::class, 'add'])->name('add');
        Route::delete('/delete/{id}', [CityController::class, 'delete'])->name('delete');
    })->name('city.');
})->name('api.');
