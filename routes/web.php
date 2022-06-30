<?php
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route form displaying our form
Route::get('/dropzone', [HomeController::class, 'index'])->name('dropzone');

//Rout for submitting the form data
Route::post('/dropzone', [HomeController::class, 'store']);

//Route for submitting dropzone data
Route::post('/store-image', [HomeController::class, 'storeImage'])->name('store-image');
?>