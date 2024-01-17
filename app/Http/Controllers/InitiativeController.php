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

    private string $wig = 'Wildly Important Goal (WIG)';
    private string $ig = 'Important Goal (IG)';
    
    public function index()
    {
        $acts = Activity::all();
        $actWIG = Activity::where('status', $this->wig)->get();
        $actIG = Activity::where('status', $this->ig)->get();
        $WIGWeight = Activity::where('status', $this->wig)->sum('weight');
        $IGWeight = Activity::where('status', $this->ig)->sum('weight');
        return view('initiative.index', compact('acts', 'actWIG', 'actIG', 'WIGWeight', 'IGWeight'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($act_id)
    {
        $act = Activity::findOrFail($act_id);
        $users = User::where('divisi_id', '!=', '1')->orderBy('fullname', 'asc')->get()->pluck('fullname', 'id');
        return view('initiative.create', compact('users', 'act'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $init = Initiative::findOrFail($id);
        $users = User::where('divisi_id', '!=', '1')->orderBy('fullname', 'asc')->get()->pluck('fullname', 'id');
        return view('initiative.edit', compact('init', 'users'));
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
        $init = Initiative::findOrFail($id);
        
        $validatedData = $request->validate([
            'initiative' => 'required',
            'weight' => 'required',
            'target_type' => 'required',
            'target' => 'required',
            'user_id' => 'required',
        ]);

        if ($init->update($validatedData)) {
            return redirect(route('init.index'))->with('success', 'Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $init = Initiative::findOrFail($id);
        if ($init->delete()) {
            return redirect(route('init.index'))->with('success', 'Deleted Successfully');
        }

        return redirect(route('init.index'))->with('error', 'Sorry, unable to delete this');
    }
}