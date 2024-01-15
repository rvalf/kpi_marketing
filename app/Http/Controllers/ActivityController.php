<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    private string $wig = 'Wildly Important Goal (WIG)';
    private string $ig = 'Important Goal (IG)';

    private function checkWeight($status, $weight) {
        if ($status == $this->wig) {
            $currentWIGWeight = Activity::where('status', $this->wig)->sum('weight');
            $maxWeight = Activity::$_maxWeightWIG - $currentWIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.create'))->withErrors(['error' => 'Acitvity WIG is Full!']);
            }

            if ($weight > $maxWeight) {
                return redirect(route('act.create'))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        } else {
            $currentIGWeight = Activity::where('status', $this->ig)->sum('weight');
            $maxWeight = Activity::$_maxWeightIG - $currentIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.create'))->withErrors(['error' => 'Acitvity IG is Full!']);
            }

            if ($weight > $maxWeight) {
                return redirect(route('act.create'))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        }
    }

    public function index()
    {
        $acts = Activity::all();
        $WIGWeight = Activity::where('status', $this->wig)->sum('weight');
        $IGWeight = Activity::where('status', $this->ig)->sum('weight');
        return view('activity.index', compact('acts', 'WIGWeight', 'IGWeight'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actsWIG = Activity::where('status', 'Wildly Important Goal (WIG)')->get();
        $actsIG = Activity::where('status', 'Important Goal (IG)')->get();
        return view('activity.create', compact('actsWIG', 'actsIG'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('status') == $this->wig) {
            $currentWIGWeight = Activity::where('status', $this->wig)->sum('weight');
            $maxWeight = Activity::$_maxWeightWIG - $currentWIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.create'))->withErrors(['error' => 'Acitvity WIG is Full!']);
            }

            if ($request->input('weight') > $maxWeight) {
                return redirect(route('act.create'))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        } else {
            $currentIGWeight = Activity::where('status', $this->ig)->sum('weight');
            $maxWeight = Activity::$_maxWeightIG - $currentIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.create'))->withErrors(['error' => 'Acitvity IG is Full!']);
            }

            if ($request->input('weight') > $maxWeight) {
                return redirect(route('act.create'))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        }

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
        $actsWIG = Activity::where('status', 'Wildly Important Goal (WIG)')->get();
        $actsIG = Activity::where('status', 'Important Goal (IG)')->get();
        return view('activity.edit', compact('activity', 'actsWIG', 'actsIG'));
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
        if ($request->input('status') == $this->wig) {
            $currentWIGWeight = Activity::where('status', $this->wig)->sum('weight');
            $maxWeight = Activity::$_maxWeightWIG - $currentWIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.edit', ['id' => $id]))->withErrors(['error' => 'Acitvity WIG is Full!']);
            }

            if ($request->input('weight') > $maxWeight) {
                return redirect(route('act.edit', ['id' => $id]))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        } else {
            $currentIGWeight = Activity::where('status', $this->ig)->sum('weight');
            $maxWeight = Activity::$_maxWeightIG - $currentIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.edit', ['id' => $id]))->withErrors(['error' => 'Acitvity IG is Full!']);
            }

            if ($request->input('weight') > $maxWeight) {
                return redirect(route('act.edit', ['id' => $id]))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        }

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