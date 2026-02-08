<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Models\DoctorSchedule;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DoctorSchedule::with('doctor', 'slots')->paginate(20);
    }


    public function store(StoreScheduleRequest $r)
    {
        $data = $r->validated();
        $schedule = DoctorSchedule::create($data);


        // auto-generate slots for this schedule for a single day template
        $this->generateSlotsForSchedule($schedule);


        return response()->json($schedule->load('slots'), 201);
    }



    public function show(DoctorSchedule $doctorSchedule)
    {
        return $doctorSchedule->load('slots');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function update(StoreScheduleRequest $r, DoctorSchedule $doctorSchedule)
    {
        $doctorSchedule->update($r->validated());
        // regenerate slots if needed (simple approach: delete&regenerate)
        $doctorSchedule->slots()->delete();
        $this->generateSlotsForSchedule($doctorSchedule);
        return response()->json($doctorSchedule->load('slots'));
    }


    public function destroy(DoctorSchedule $doctorSchedule)
    {
        $doctorSchedule->delete();
        return response()->noContent();
    }

    protected function generateSlotsForSchedule(DoctorSchedule $schedule)
    {
        $start = Carbon::createFromFormat('H:i', $schedule->start_time);
        $end = Carbon::createFromFormat('H:i', $schedule->end_time);
        $duration = $schedule->slot_duration ?: 15;


        $cur = $start->copy();
        $slots = [];
        while ($cur->lt($end)) {
            $slots[] = ['schedule_id' => $schedule->id, 'slot_time' => $cur->format('H:i:s'), 'created_at' => now(), 'updated_at' => now()];
            $cur->addMinutes($duration);
        }


        if (!empty($slots)) TimeSlot::insert($slots);
    }
}
