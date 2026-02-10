<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return DoctorSchedule::with('doctor', 'slots')->paginate(20);
        if (request()->expectsJson()) {
            return DoctorSchedule::with('doctor', 'slots')->paginate(20);
        }

        $doctors = Doctor::select('id', 'name')->get();
        return view('schedules.index', compact('doctors'));
    }


    public function store(StoreScheduleRequest $r)
    {
        $data = $r->validated();
        $schedule = DoctorSchedule::create($data);


        // auto-generate slots for this schedule for a single day template
        $this->generateSlotsForSchedule($schedule);


        return response()->json($schedule->load('slots'), 201);
    }


    public function show($id)
    {
        $schedule = DoctorSchedule::with(['doctor', 'slots'])->find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $schedule
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function update(StoreScheduleRequest $request, DoctorSchedule $schedule)
    {
        // dd($schedule->exists, $schedule->id);
        $schedule->update($request->validated());
        $schedule->slots()->delete();
        $this->generateSlotsForSchedule($schedule);

        return response()->json([
            'success' => true,
            'message' => 'Doctor schedule updated successfully',
            'data' => $schedule->load(['doctor', 'slots']),
        ]);
    }

    public function destroy(DoctorSchedule $schedule)
    {
        // ensure atomic delete
        DB::transaction(function () use ($schedule) {
            $schedule->slots()->delete();
            $schedule->delete();
        });

        return response()->json(['message' => 'Schedule deleted successfully!', 'success' => true]);
    }

    protected function generateSlotsForSchedule(DoctorSchedule $schedule)
    {
        $start = Carbon::createFromFormat('H:i', $schedule->start_time);
        $end   = Carbon::createFromFormat('H:i', $schedule->end_time);

        // ensure duration is int
        $duration = (int) ($schedule->slot_duration ?: 15);

        $cur = $start->copy();
        $slots = [];

        while ($cur->lt($end)) {
            $slots[] = [
                'schedule_id' => $schedule->id,
                'slot_time'   => $cur->format('H:i:s'),
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
            $cur->addMinutes($duration); // ✅ now it's int
        }

        if (!empty($slots)) {
            TimeSlot::insert($slots);
        }
    }


}
