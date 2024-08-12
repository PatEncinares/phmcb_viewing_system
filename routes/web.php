<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\DoctorDetailsController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\SubSpecializationController;

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

    Route::get('specialization', [SpecializationController::class, 'index']);
    Route::get('specialization/getrecords', [SpecializationController::class, 'get_records']);
    Route::post('specialization/store', [SpecializationController::class, 'store']);
    Route::get('specialization/edit/{id}', [SpecializationController::class, 'edit']);
    Route::get('specialization/destroy/{id}', [SpecializationController::class, 'destroy']);

    Route::get('subspecialization', [SubSpecializationController::class, 'index']);
    Route::get('subspecialization/getrecords', [SubSpecializationController::class, 'get_records']);
    Route::post('subspecialization/store', [SubSpecializationController::class, 'store']);
    Route::get('subspecialization/edit/{id}', [SubSpecializationController::class, 'edit']);
    Route::get('subspecialization/destroy/{id}', [SubSpecializationController::class, 'destroy']);


});

