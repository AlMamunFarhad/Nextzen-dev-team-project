<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'data' => Clinic::latest()->get()
            ]);
        }

        return view('clinics.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'primary_color' => 'nullable|string',
        ]);

        $clinic = Clinic::updateOrCreate(
            ['id' => $request->clinic_id],
            $data
        );

        return response()->json([
            'message' => 'Clinic saved successfully',
            'data' => $clinic
        ]);
    }

    public function analytics()
    {
        $clinicId = Clinic::first()->id ?? null;
        $totalAppointments = Appointment::where('clinic_id', $clinicId)->count();
        $revenue = Appointment::where('clinic_id', $clinicId)->where('payment_status', 'paid')->sum('fee');
        $peakHours = Appointment::where('clinic_id', $clinicId)
            ->selectRaw('HOUR(scheduled_at) as hour, count(*) as total')
            ->groupBy('hour')
            ->orderByDesc('total')->get();

        return view('clinics.analytics', compact('totalAppointments', 'revenue', 'peakHours'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Clinic $clinic)
    {
        return response()->json([
            'data' => $clinic
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, Clinic $clinic)
    {

        $data = $r->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'primary_color' => 'nullable|string',
        ]);

        $clinic->update($data);

        return response()->json([
            'message' => 'Clinic updated successfully',
            'data' => $clinic
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy(Clinic $clinic)
    {
        $clinic->delete();

        return response()->json([
            'message' => 'Clinic deleted successfully'
        ]);
    }
}
