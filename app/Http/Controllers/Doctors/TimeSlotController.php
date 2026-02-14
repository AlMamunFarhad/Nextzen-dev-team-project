<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $r)
    {
        $query = TimeSlot::with('schedule.doctor');
        if ($r->filled('doctor_id')) {
            $query->whereHas('schedule', function ($q) use ($r) {
                $q->where('doctor_id', $r->doctor_id);
            });
        }
        if ($r->filled('date')) {
            // slots are template times; date filter handled at appointment time
        }

        return $query->paginate(30);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getByDoctorAndDate(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
        ]);

        $slots = TimeSlot::whereHas('schedule', function ($q) use ($request) {
            $q->where('doctor_id', $request->doctor_id);
        })
            ->get();

        return response()->json($slots);
    }
}
