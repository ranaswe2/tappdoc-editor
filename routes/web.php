<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/editor', function () {
    return view('WordProcessor');
});

Route::get('create',[DocumentController::class,'create']);
Route::post('convert-doc-to-html',[DocumentController::class,'convertDocToHtml']);
Route::post('view-doc-to-html',[DocumentController::class,'viewDocToHtml']);