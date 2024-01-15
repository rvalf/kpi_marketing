<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acts = Activity::all();
        return view('activity.index', compact('acts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activity.create');
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
                'status' => 'required',
                'objective' => 'required',
                'weight' => 'required',
                'target_type' => 'required',
                'target' => 'required',
            ]);
    
            Activity::create($validatedData);
    
            return redirect(route('act.index'))->with('success', 'Created Successfully');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create: ' . $e->getMessage());
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
        $activity = Activity::findOrFail($id);

        return view('act.edit', compact('activity'));

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
        $activity = Activity::findOrFail($id);
        $validatedData = $request->validate([
            'status' => 'required', 
            'objective' => 'required',
            'weight' => 'required',
            'target_type' => 'required',
            'target' => 'required',
         ]);

        if ($activity->update($validatedData)) {
            return redirect(route('act.index'))->with('success', 'Updated Successfully');
        } else {
            // Handle the case where the update fails
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
        $activity = Activity::findOrFail($id);
        if ($activity->delete()) {
            return redirect(route('act.index'))->with('success', 'Deleted Successfully');
        }

        return redirect(route('act.index'))->with('error', 'Sorry, unable to delete this');
    }
}
