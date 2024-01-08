<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function staff() {
        return view('staff.dashboard');
    }
}
