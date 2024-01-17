<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');

        // $user = Auth::user();

        // if ($user->divisi->name != 'Manager') {
        //     return redirect()->route('dashboard.staff');
        // } else {
        //     return view('manager.dashboard');
        // }
    }
}
