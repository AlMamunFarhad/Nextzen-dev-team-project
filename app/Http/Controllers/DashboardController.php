<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function userdashboard()
    {
        return view('dashboard');
    }

    public function sellerdashboard()
    {
        return view('seller');
    }

    public function admindashboard()
    {
        return view('admin');
    }
}
