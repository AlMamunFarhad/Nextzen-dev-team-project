<?php

require __DIR__ . '/auth.php';

use App\Http\Controllers\ClinicController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Doctors\AppointmentController;
use App\Http\Controllers\Doctors\DoctorController;
use App\Http\Controllers\Doctors\DoctorScheduleController;
use App\Http\Controllers\Doctors\PatientController;
use App\Http\Controllers\Doctors\TimeSlotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('index');
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function() {
    Route::resource('doctors', DoctorController::class);
    Route::resource('schedules', DoctorScheduleController::class);
    Route::get('slots', [TimeSlotController::class, 'index']);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('patients', PatientController::class);


    // video call route
    Route::get('/video-call/{{appointment}}', [VideoController::class, 'join'])->name('video.call');

    Route::get('/video/{id}/started', [VideoController::class, 'started'])->name('video.started');
    Route::get('/video/{id}/ended', [VideoController::class, 'ended'])->name('video.ended');


});


Route::get('patient/dashboard', [DashboardController::class, 'userdashboard'])->middleware('auth', 'patient')->name('patient.dashboard');
Route::get('doctor/dashboard', [DashboardController::class, 'sellerdashboard'])->middleware('auth', 'doctor')->name('doctor.dashboard');
Route::get('admin/dashboard', [DashboardController::class, 'admindashboard'])->middleware('auth', 'admin')->name('admin.dashboard');




// Clinic Route
Route::resource('clinics', ClinicController::class);

// Contact Route

Route::post('/contact-send', [ContactController::class, 'send'])->name('contact.send');


