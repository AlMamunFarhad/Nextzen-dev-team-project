<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $roles = [
            'admin' => 0,
            'doctor' => 1,
            'patient' => 2,
            'receptionist' => 3,
        ];

        if (!isset($roles[$role])) {
            abort(400, 'Invalid role middleware parameter.');
        }

        if (Auth::user()->role === $roles[$role]) {
            return $next($request);
        }

        switch (Auth::user()->role) {
            case $roles['admin']:
                return redirect()->route('admin.dashboard');
            case $roles['doctor']:
                return redirect()->route('doctor.dashboard');
            case $roles['patient']:
                return redirect()->route('patient.dashboard');
            case $roles['receptionist']:
                return redirect()->route('receptionist.dashboard');
            default:
                return redirect()->route('login');
        }
    }
}
