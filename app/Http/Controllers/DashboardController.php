<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function userdashboard()
    {
        return view('patient');
    }

    public function sellerdashboard()
    {
        return view('doctor');
    }

    public function admindashboard()
    {
        return view('admin');
    }
    public function receptionistDashboard()
    {
        return view('receptionist');
    }

    public function reports()
    {
            $clinicId = auth()->user()->clinic_id;

    // 1️⃣ Today Appointments
    $today = now()->toDateString();
    $todayAppointments = Appointment::where('clinic_id',$clinicId)
        ->whereDate('appointment_date',$today)
        ->get();

    // 2️⃣ Last 30 Days Revenue
    $revenue = Appointment::where('clinic_id',$clinicId)
        ->where('payment_status','paid')
        ->whereDate('appointment_date','>=', now()->subDays(30))
        ->sum('fee');

    // 3️⃣ Doctor Commission Report
    $report = Appointment::where('clinic_id',$clinicId)
        ->where('payment_status','paid')
        ->selectRaw('doctor_id, SUM(commission_amount) as due')
        ->groupBy('doctor_id')
        ->with('doctor')
        ->get();

    return view('reports.reports', compact(
        'todayAppointments',
        'revenue',
        'report'
    ));
        // return view('reports.reports');
    }
}
