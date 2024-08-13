<?php

use App\Http\Controllers\BuildingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\DoctorDetailsController;
use App\Http\Controllers\DoctorSpecializationController;
use App\Http\Controllers\HmoController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\SubSpecializationController;
use App\Models\Building;
use App\Models\DoctorSpecialization;

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
    // MASTER DATA

    // MASTER DATA DOCTORS
    Route::get('doctordetails', [DoctorDetailsController::class, 'index']);
    Route::get('doctordetails/getrecords', [DoctorDetailsController::class, 'get_records']);
    Route::post('doctordetails/store', [DoctorDetailsController::class, 'store']);
    Route::get('doctordetails/edit/{id}', [DoctorDetailsController::class, 'edit']);
    Route::get('doctordetails/destroy{id}', [DoctorDetailsController::class, 'destroy']);

    // MASTER DATA SPECIALIZATION
    Route::get('specialization', [SpecializationController::class, 'index']);
    Route::get('specialization/getrecords', [SpecializationController::class, 'get_records']);
    Route::post('specialization/store', [SpecializationController::class, 'store']);
    Route::get('specialization/edit/{id}', [SpecializationController::class, 'edit']);
    Route::get('specialization/destroy/{id}', [SpecializationController::class, 'destroy']);

    // MASTER DATA SUB SPECIALIZATION
    Route::get('subspecialization', [SubSpecializationController::class, 'index']);
    Route::get('subspecialization/getrecords', [SubSpecializationController::class, 'get_records']);
    Route::post('subspecialization/store', [SubSpecializationController::class, 'store']);
    Route::get('subspecialization/edit/{id}', [SubSpecializationController::class, 'edit']);
    Route::get('subspecialization/destroy/{id}', [SubSpecializationController::class, 'destroy']);

    // MASTER DATA HMO
    Route::get('hmo', [HmoController::class, 'index']);
    Route::get('hmo/getrecords', [HmoController::class, 'get_records']);
    Route::post('hmo/store', [HmoController::class, 'store']);
    Route::get('hmo/edit/{id}', [HmoController::class, 'edit']);
    Route::get('hmo/destroy/{id}', [HmoController::class, 'destroy']);

    // MASTER DATA BUILDING
    Route::get('building', [BuildingController::class, 'index']);
    Route::get('building/getrecords', [BuildingController::class, 'get_records']);
    Route::post('building/store', [BuildingController::class, 'store']);
    Route::get('building/edit/{id}', [BuildingController::class, 'edit']);
    Route::get('building/destroy/{id}', [BuildingController::class, 'destroy']);

    // MASTER DATA ROOM
    Route::get('room', [RoomsController::class, 'index']);
    Route::get('room/getrecords', [RoomsController::class, 'get_records']);
    Route::post('room/store', [RoomsController::class, 'store']);
    Route::get('room/edit/{id}', [RoomsController::class, 'edit']);
    Route::get('room/destroy/{id}', [RoomsController::class, 'destroy']);

    // END OF MASTER DATA

    // OTHER TAGGING WEBS

    //DOCTOR SPECIALIZATION
    Route::get('doctor_specialization', [DoctorSpecializationController::class, 'index']);
    Route::get('doctor_specialization/getrecords', [DoctorSpecializationController::class, 'get_records']);
    Route::post('doctor_specialization/store', [DoctorSpecializationController::class, 'store']);
    Route::get('doctor_specialization/edit/{id}', [DoctorSpecializationController::class, 'edit']);
    Route::get('doctor_specialization/destroy/{id}', [DoctorSpecializationController::class, 'destroy']);
    Route::get('doctor_specialization/get_sub_specialization_by_specialization/{id}', [DoctorSpecializationController::class, 'get_sub_specialization_by_specialization']);

});

