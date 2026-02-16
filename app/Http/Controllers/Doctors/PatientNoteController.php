<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Models\PatientNote;
use Illuminate\Http\Request;

class PatientNoteController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate([
            'clinic_id' => 'required|exists:clinics,id',
            'patient_id' => 'required|exists:users,id',
            'note' => 'required|string',
            'follow_up_date' => 'nullable|date'
        ]);
        $data['author_id'] = auth()->id();
        PatientNote::create($data);
        return back()->with('success', 'Note saved');
    }
}
