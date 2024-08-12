<?php

use App\Http\Controllers\DoctorDetailsController;
use App\Http\Controllers\RoomsController;
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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', function () {
        return view('/home');
    });

    Route::get('doctordetails', [DoctorDetailsController::class, 'index']);
    Route::get('doctordetails/getrecords', [DoctorDetailsController::class, 'get_records']);
    Route::post('doctordetails/store', [DoctorDetailsController::class, 'store']);
    Route::get('doctordetails/edit/{id}', [DoctorDetailsController::class, 'edit']);
    Route::get('doctordetails/destroy{id}', [DoctorDetailsController::class, 'destroy']);

    Route::get('room', [RoomsController::class, 'index']);
    Route::get('room/getrecords', [RoomsController::class, 'get_records']);
    Route::post('room/store', [RoomsController::class, 'store']);
    Route::get('room/edit/{id}', [RoomsController::class, 'edit']);
    Route::get('room/destroy/{id}', [RoomsController::class, 'destroy']);
});

