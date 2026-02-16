<?php

require __DIR__ . '/auth.php';


// use App\Http\Controllers\Doctors\AppointmentController;
// use App\Http\Controllers\Doctors\ClinicController;
// use App\Http\Controllers\Doctors\DoctorController;
// use App\Http\Controllers\Doctors\DoctorScheduleController;
// use App\Http\Controllers\Doctors\PatientController;
// use App\Http\Controllers\Doctors\PatientNoteController;
// use App\Http\Controllers\Doctors\TimeSlotController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Models\Clinic;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctors\{
    DoctorController,
    DoctorScheduleController,
    TimeSlotController,
    AppointmentController,
    PatientController,
    PatientNoteController,
    ClinicController,
};



Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// -------------------------------
// Admin Routes
// -------------------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'admindashboard'])->name('admin.dashboard');

    Route::resource('clinics', ClinicController::class);

    // Doctors & Schedules
    Route::resource('doctors', DoctorController::class);
    Route::resource('schedules', DoctorScheduleController::class);

    // Slots
    Route::get('slots', [TimeSlotController::class, 'index']);

    // Appointments
    Route::get('appointments/list', [AppointmentController::class, 'appointmentList'])->name('appointments.list');
    Route::get('appointments-data', [AppointmentController::class, 'data'])->name('appointments.data');
    Route::get('time-slots', [AppointmentController::class, 'getSlots'])->name('appointments.slots');
    Route::resource('appointments', AppointmentController::class);

    // Patients
    Route::resource('patients', PatientController::class);
    Route::get('patients-data', [PatientController::class, 'data'])->name('patients.data');

    // Analytics & Reports
    Route::get('analytics', [ClinicController::class, 'analytics'])->name('admin.analytics');
    Route::get('reports', [DashboardController::class, 'reports'])->name('reports.reports');

    // Clinic specific data
    Route::get('clinics/{clinic}/doctors', function (App\Models\Clinic $clinic) {
        return $clinic->doctors()->select('id', 'name', 'consultation_fee')->get();
    })->name('clinics.doctors');

    // -------------------------------
    // Manual Booking (Admin + Receptionist)
    // -------------------------------
    Route::middleware('role:receptionist')->group(function () {
        Route::get('manual-book', [AppointmentController::class, 'showManualForm'])->name('admin.manual.book.form');
        Route::post('manual-book', [AppointmentController::class, 'manualBook'])->name('admin.manual.book');

        Route::post('patient-notes', [PatientNoteController::class, 'store'])->name('admin.patient.notes.store');
    });
});

// -------------------------------
// Receptionist Dashboard
// -------------------------------
Route::middleware(['auth', 'role:receptionist'])->prefix('receptionist')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'receptionistDashboard'])->name('receptionist.dashboard');
});

// -------------------------------
// Doctor Dashboard
// -------------------------------
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'sellerdashboard'])->name('doctor.dashboard');
});

// -------------------------------
// Patient Dashboard
// -------------------------------
Route::middleware(['auth', 'role:patient'])->prefix('patient')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'userdashboard'])->name('patient.dashboard');
});




// Route::middleware('auth', 'role:admin')->group(function () {
//     Route::resource('doctors', DoctorController::class);
//     Route::resource('schedules', DoctorScheduleController::class);
//     Route::get('slots', [TimeSlotController::class, 'index']);
//     Route::get('/appointments/list', [AppointmentController::class, 'appointmentList'])
//         ->name('appointments.list');
//     Route::resource('appointments', AppointmentController::class);
//     Route::get('appointments-data', [AppointmentController::class, 'data'])
//         ->name('appointments.data');
//     Route::get('time-slots', [AppointmentController::class, 'getSlots'])
//         ->name('appointments.slots');
//     Route::resource('patients', PatientController::class);
//     Route::get('patients-data', [PatientController::class, 'data'])
//         ->name('patients.data');
//             Route::get('analytics', [ClinicController::class,'analytics'])->name('admin.analytics');

//     Route::get('/clinics/{clinic}/doctors', function(Clinic $clinic){
//     return $clinic->doctors()->select('id','name','consultation_fee')->get();
//     })->name('clinics.doctors');

//     Route::get('reports', [DashboardController::class, 'reports'])->name('reports.reports');
//     // Manual booking (admin + receptionist)
//     Route::middleware('role:receptionist')->group(function () {
//         Route::get('manual-book', [AppointmentController::class,'showManualForm'])->name('admin.manual.book.form');
//         Route::post('manual-book', [AppointmentController::class,'manualBook'])->name('admin.manual.book');
//         Route::post('patient-notes', [PatientNoteController::class,'store'])->name('admin.patient.notes.store');
//     });
// });

// Route::get('patient/dashboard', [DashboardController::class, 'userdashboard'])->middleware('auth', 'role:patient')->name('patient.dashboard');
// Route::get('doctor/dashboard', [DashboardController::class, 'sellerdashboard'])->middleware('auth', 'role:doctor')->name('doctor.dashboard');
// Route::get('admin/dashboard', [DashboardController::class, 'admindashboard'])->middleware('auth', 'role:admin')->name('admin.dashboard');
// Route::get('receptionist/dashboard', [DashboardController::class, 'receptionistDashboard'])->middleware('auth', 'role:receptionist')->name('receptionist.dashboard');
