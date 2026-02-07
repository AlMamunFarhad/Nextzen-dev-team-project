<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route("login");
        }

        // Get the authenticated user's role
        $authUserRole = Auth::user()->role;

        // Define role mappings
        $roles = [
            'admin' => 0,
            'patient' => 1,
            'doctor' => 2,
        ];

        // Check if the user's role matches the requested role
        if (isset($roles[$role]) && $authUserRole == $roles[$role]) {
            return $next($request);
        }

        // Redirect based on the user's role
        switch ($authUserRole) {
            case 0:
                return redirect()->route('admin');
            case 1:
                return redirect()->route('vendor');
            case 2:
                return redirect()->route('dashboard');
            default:
                return redirect()->route('login');
        }
    }



    // public function handle(Request $request, Closure $next, $role): Response
    // {
    //     if(!Auth::check()) {
    //         return redirect()->route("login");
    //     }

    //     $authUserRole = Auth::user()->role;
    //     switch($role) {
    //         case "admin":
    //             if($authUserRole == 0) {
    //                 return $next($request);
    //             }
    //         break;
    //         case "vendor":
    //             if($authUserRole == 1) {
    //                 return $next($request);
    //             }
    //         break;
    //         case "customer":
    //             if($authUserRole == 2) {
    //                 return $next($request);
    //             }
    //         break;
    //     }

    //     switch($authUserRole) {
    //         case 0:
    //             return redirect()->route("admin");
    //             break;
    //         case 1:
    //             return redirect()->route("vendor");
    //             break;
    //         case 2:
    //             return redirect()->route("dashboard");
    //             break;
    //     }

    //     return redirect()->route("login");
    //Farhad
    // }
}
