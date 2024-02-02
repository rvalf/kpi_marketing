<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
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
    
    public function index()
    {
        $acts = Activity::whereYear('created_at', now()->year)->get();
        $actWIG = Activity::where('status', $this->wig)->whereYear('created_at', now()->year)->get();
        $actIG = Activity::where('status', $this->ig)->whereYear('created_at', now()->year)->get();
        $WIGWeight = Activity::where('status', $this->wig)->whereYear('created_at', now()->year)->sum('weight');
        $IGWeight = Activity::where('status', $this->ig)->whereYear('created_at', now()->year)->sum('weight');

        $progresActWIG = [];

        foreach ($actWIG as $activity) {
            $totalProgresActivityUtama = 0;
            $totalBobot = 0;
            foreach ($activity->initiatives as $init) {
                $lastReport = $init->reports->last();
                $progres = $lastReport ? $lastReport->actual : 0;
                if ($init->target_type != 'Precentage') {
                    $progres = ($progres / $init->target) * 100;
                }
                $totalBobot += $init->weight;
                $totalProgresActivityUtama += ($init->weight / 100) * $progres;
            }
            $progresActWIG[$activity->id] = $totalProgresActivityUtama;
        }

        $progresActIG = [];

        foreach ($actIG as $activity) {
            $totalProgresActivityUtama = 0;
            $totalBobot = 0;
            foreach ($activity->initiatives as $init) {
                $lastReport = $init->reports->last();
                $progres = $lastReport ? $lastReport->actual : 0;
                if ($init->target_type != 'Precentage') {
                    $progres = ($progres / $init->target) * 100;
                }
                $totalBobot += $init->weight;
                $totalProgresActivityUtama += ($init->weight / 100) * $progres;
            }
            $progresActIG[$activity->id] = $totalProgresActivityUtama;
        }

        return view('activity.index', compact('acts', 'actWIG', 'actIG', 'WIGWeight', 'IGWeight',
        'progresActWIG', 'progresActIG'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actsWIG = Activity::where('status', $this->wig)->whereYear('created_at', now()->year)->get();
        $actsIG = Activity::where('status', $this->ig)->whereYear('created_at', now()->year)->get();
        return view('activity.create', compact('actsWIG', 'actsIG'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreActivityRequest $request)
    {
        $params = $request->validated();

        if ($request->input('status') == $this->wig) {
            $currentWIGWeight = Activity::where('status', $this->wig)->whereYear('created_at', now()->year)->sum('weight');
            $maxWeight = Activity::$_maxWeightWIG - $currentWIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.create'))->withErrors(['error' => 'Acitvity WIG is Full!']);
            }

            if ($request->input('weight') > $maxWeight) {
                return redirect(route('act.create'))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        } else {
            $currentIGWeight = Activity::where('status', $this->ig)->whereYear('created_at', now()->year)->sum('weight');
            $maxWeight = Activity::$_maxWeightIG - $currentIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.create'))->withErrors(['error' => 'Acitvity IG is Full!']);
            }

            if ($request->input('weight') > $maxWeight) {
                return redirect(route('act.create'))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        }

        try {
            $params['target_type'] = 'Precentage';
            $params['target'] = 100;
    
            Activity::create($params);
    
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
        $activity = Activity::whereYear('created_at', now()->year)->findOrFail($id);
        $actsWIG = Activity::where('status', $this->wig)->whereYear('created_at', now()->year)->get();
        $actsIG = Activity::where('status', $this->ig)->whereYear('created_at', now()->year)->get();
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
            $currentWIGWeight = Activity::where('status', $this->wig)->where('id', '!=', $id)->whereYear('created_at', now()->year)->sum('weight'); 
            $maxWeight = Activity::$_maxWeightWIG - $currentWIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.edit', ['id' => $id]))->withErrors(['error' => 'Acitvity WIG is Full!']);
            }

            if ($request->input('weight') > $maxWeight) {
                return redirect(route('act.edit', ['id' => $id]))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        } else {
            $currentIGWeight = Activity::where('status', $this->ig)->where('id', '!=', $id)->whereYear('created_at', now()->year)->sum('weight');
            $maxWeight = Activity::$_maxWeightIG - $currentIGWeight;

            if ($maxWeight == 0) {
                return redirect(route('act.edit', ['id' => $id]))->withErrors(['error' => 'Acitvity IG is Full!']);
            }

            if ($request->input('weight') > $maxWeight) {
                return redirect(route('act.edit', ['id' => $id]))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
            }
        }

        $activity = Activity::whereYear('created_at', now()->year)->findOrFail($id);
        $validatedData = $request->validate([
            'status' => 'required', 
            'objective' => 'required',
            'weight' => 'required',
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
        $activity = Activity::whereYear('created_at', now()->year)->findOrFail($id);
        if ($activity->initiatives->isNotEmpty()) {
            return redirect(route('act.index'))->with('error', 'Sorry, unable to delete this. Activity already has initiatives.');
        }

        if ($activity->delete()) {
            return redirect(route('act.index'))->with('success', 'Deleted Successfully');
        }

        return redirect(route('act.index'))->with('error', 'Sorry, unable to delete this');
    }
}