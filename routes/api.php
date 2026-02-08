<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// // api.php
// use App\Http\Controllers\DoctorController;
// use App\Http\Controllers\DoctorScheduleController;
// use App\Http\Controllers\TimeSlotController;
// use App\Http\Controllers\AppointmentController;
// use App\Http\Controllers\PatientController;

// Route::middleware('auth:sanctum')->group(function(){
//     Route::apiResource('doctors', DoctorController::class);
//     Route::apiResource('schedules', DoctorScheduleController::class);
//     Route::get('slots', [TimeSlotController::class, 'index']);
//     Route::apiResource('appointments', AppointmentController::class);
//     Route::apiResource('patients', PatientController::class);
// });
