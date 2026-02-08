<?php

namespace App\Http\Controllers;

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
}
