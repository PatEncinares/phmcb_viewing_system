<?php

use App\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', function () {
        return view('/home');
    });


    Route::get('specialization', [SpecializationController::class, 'index']);
    Route::get('specialization/getrecords', [SpecializationController::class, 'get_records']);
    Route::post('specialization/store', [SpecializationController::class, 'store']);
    Route::get('specialization/edit/{id}', [SpecializationController::class, 'edit']);
    Route::get('specialization/destroy/{id}', [SpecializationController::class, 'destroy']);
});

