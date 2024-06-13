<?php

use App\Http\Controllers\ExportHTML;
use App\Http\Controllers\HtmlConversionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('tinymce');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/generation-tailwind', function () {
    return view('generation-tailwind');
});
Route::post('/convert-to-tailwind', [HtmlConversionController::class, 'convertToTailwind']);

Route::post('/export', [ExportHTML::class, 'export']);
