<?php

use App\Models\Area;
use App\Services\CityService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\SiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

# Получаем список slug и для каждого создаем группу маршрутов, включая пустой slug
foreach ( array_merge([''], Area::whereNotNull('slug')->pluck('slug')->toArray()) as $slug ) {
    Route::group(['prefix' => $slug], function () {
        Route::get('/', [SiteController::class, 'index']);
        Route::get('/about', [SiteController::class, 'about']);
        Route::get('/news', [SiteController::class, 'news']);
        Route::get('/set/{id}', [SiteController::class, 'setCity']);
    });
}