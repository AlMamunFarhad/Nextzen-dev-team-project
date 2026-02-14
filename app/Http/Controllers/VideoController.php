<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function join($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->type !== 'video') {
            abort(403);
        }

        if ($appointment->status !== 'confirmed') {
            abort(403);
        }

        // Access check
        if (
            auth()->id() !== $appointment->patient->user_id &&
            auth()->id() !== $appointment->doctor->user_id
        ) {
            abort(403);
        }

        // Time window (10 min before to 2 hour after)
        $start = \Carbon\Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);
        $now = now();

        if ($now->lt($start->subMinutes(10)) || $now->gt($start->addHours(2))) {
            return back()->with('error', 'Meeting not available at this time.');
        }

        return view('videoCall.video-call', compact('appointment'));
    }





    public function started($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'meeting_status' => 'started',
            'started_at' => now()
        ]);
    }

    public function ended($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'meeting_status' => 'ended',
            'ended_at' => now()
        ]);
    }



}
