<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Initiative;
use App\Models\User;
use Illuminate\Http\Request;

class InitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inits = Initiative::all();
        $acts = Activity::all();
        return view('initiative.index', compact('inits', 'acts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acts = Activity::orderBy('objective', 'asc')->get()->pluck('objective', 'id');
        $users = User::where('divisi_id', '!=', '1')->orderBy('fullname', 'asc')->get()->pluck('fullname', 'id');
        return view('initiative.create', compact('acts', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validatedData = $request->validate([
                'activity_id' => 'required',
                'initiative' => 'required',
                'weight' => 'required',
                'target_type' => 'required',
                'target' => 'required',
                'user_id' => 'required',
            ]);
    
            Initiative::create($validatedData);
    
            return redirect(route('init.index'))->with('success', 'Created Successfully');
        }catch (\Exception $e) {
            return redirect(route('init.create'))->withErrors(['error' => 'Error: ' . $e->getMessage()]);
            // return redirect()->back()->with('error', 'Failed to create: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
