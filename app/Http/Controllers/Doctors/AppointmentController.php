<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        $patients = Patient::with('user')->get();
        // $appointments = Appointment::with([
        //     'doctor.user',
        //     'patient.user',
        //     'slot',
        // ])->latest()->paginate(20);

        return view('appointments.index', compact('doctors', 'patients'));
    }

    public function appointmentList()
    {
        $appointments = Appointment::with([
            'doctor.user',
            'patient.user',
            'slot',
        ])->latest()->get();

        return response()->json($appointments);
    }

    public function data(Request $r)
    {
        $query = Appointment::with('doctor.user', 'patient.user', 'slot');

        if ($r->filled('doctor_id')) {
            $query->where('doctor_id', $r->doctor_id);
        }

        if ($r->filled('patient_id')) {
            $query->where('patient_id', $r->patient_id);
        }

        return response()->json($query->paginate(20));
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
    public function store(StoreAppointmentRequest $r)
    {
        $data = $r->validated();

        // Ensure slot not double-booked and is from the same doctor
        $slot = TimeSlot::lockForUpdate()->find($data['slot_id']);
        if (! $slot) {
            return response()->json(['message' => 'Slot not found'], 404);
        }
        if ($slot->is_booked) {
            return response()->json(['message' => 'Slot already booked'], 422);
        }

        // optional check: slot belongs to doctor's schedule
        if ($slot->schedule->doctor_id != $data['doctor_id']) {
            return response()->json(['message' => 'Slot does not belong to this doctor'], 422);
        }

        return DB::transaction(function () use ($data, $slot) {
            $slot->is_booked = 1;
            $slot->save();

            $appointment = Appointment::create([
                'doctor_id' => $data['doctor_id'],
                'patient_id' => $data['patient_id'],
                'slot_id' => $slot->id,
                'appointment_date' => $data['appointment_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            return response()->json($appointment->load('doctor.user', 'patient.user', 'slot'), 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return $appointment->load('doctor.user', 'patient.user', 'slot');
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
    public function update(Request $r, Appointment $appointment)
    {
        // For admin/doctor: change status or notes
        $this->authorizeAction($appointment);
        $data = $r->only(['status', 'notes']);
        if (isset($data['status']) && ! in_array($data['status'], ['pending', 'approved', 'completed', 'cancelled'])) {
            return response()->json(['message' => 'Invalid status'], 422);
        }

        // If cancelling, free slot
        if (isset($data['status']) && $data['status'] === 'cancelled') {
            $appointment->slot->is_booked = 0;
            $appointment->slot->save();
        }

        $appointment->update($data);

        return response()->json($appointment->fresh()->load('doctor.user', 'patient.user', 'slot'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorizeAction($appointment);
        // free slot
        $appointment->slot->is_booked = 0;
        $appointment->slot->save();
        $appointment->delete();

        return response()->noContent();
    }

    protected function authorizeAction(Appointment $appointment)
    {
        // placeholder: implement policy or middleware
        return true;
    }

    public function getSlots(Request $r)
    {
        $r->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
        ]);

        $slots = TimeSlot::with('schedule')
            ->whereHas('schedule', function ($q) use ($r) {
                $q->where('doctor_id', $r->doctor_id);
            })
            ->get();

        return response()->json($slots->map(function ($slot) {
            return [
                'id' => $slot->id,
                'start_time' => $slot->schedule->start_time ?? null,
                'end_time' => $slot->schedule->end_time ?? null,
                'is_booked' => $slot->is_booked,
            ];
        }));

    }
}
