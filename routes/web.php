<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class,'index']);
Route::get('/list', [HomeController::class,'getCustomers']);
Route::delete('/delete/{id}', [HomeController::class,'deleteCustomer']);
Route::post('/create', [HomeController::class,'addCustomer']);
Route::put('/update/{id}', [HomeController::class,'editCustomer']);
