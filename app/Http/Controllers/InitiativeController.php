<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInitiativeRequest;
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
        
        return view('initiative.index', compact('acts', 'actWIG', 'actIG', 'WIGWeight', 'IGWeight', 
        'progresActWIG', 'progresActIG'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($act_id)
    {
        $act = Activity::whereYear('created_at', now()->year)->findOrFail($act_id);
        $users = User::where('divisi_id', '!=', '1')->orderBy('fullname', 'asc')->get()->pluck('fullname', 'id');
        return view('initiative.create', compact('users', 'act'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInitiativeRequest $request)
    {
        $params = $request->validated();

        $actId = $params['activity_id'];

        if ($params['target_type'] == 'Precentage' && $params['target'] > 100) {
            return redirect(route('init.create', ['act_id' => $actId]))->withErrors(['error' => 'Max precentage target is 100%'])->withInput($request->input());
        }
        $initAll = Initiative::all();
        $currentWeight = 0;
        foreach ($initAll as $init) {
            if ($init->activity->id == $actId) {
                $currentWeight += $init->weight;
            }
        }
        
        $maxWeight = 100 - $currentWeight;
        $validatedWeight = intval($params['weight']);
        if ($validatedWeight > $maxWeight) {
            return redirect(route('init.create', ['act_id' => $actId]))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!'])->withInput($request->input());
        }

        try {
            Initiative::create($params);
    
            return redirect(route('init.index'))->with('success', 'Created Successfully');
        }catch (\Exception $e) {
            return redirect(route('init.create', ['act_id' => $actId]))->withErrors(['error' => 'Error: ' . $e->getMessage()]);
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

        $actId = $init->activity->id;
        $initAll = Initiative::where('id', '!=', $id)->get();
        $currentWeight = 0;
        foreach ($initAll as $in) {
            if ($in->activity->id == $actId) {
                $currentWeight += $in->weight;
            }
        }
        
        $maxWeight = 100 - $currentWeight;
        $validatedWeight = intval($validatedData['weight']);
        if ($validatedWeight > $maxWeight) {
            return redirect(route('init.edit', ['id' => $id]))->withErrors(['error' => 'Max Weight '.$maxWeight.'%!']);
        }

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

        if ($init->reports->isNotEmpty()) {
            return redirect(route('init.index'))->with('error', 'Sorry, unable to delete this. Initiative already has reports.');
        }

        if ($init->delete()) {
            return redirect(route('init.index'))->with('success', 'Deleted Successfully');
        }

        return redirect(route('init.index'))->with('error', 'Sorry, unable to delete this');
    }

    public function getProgres($activity_id) {
        $activity = Activity::whereYear('created_at', now()->year)->findOrFail($activity_id);
        $totalProgresActivityUtama = 0;
        $totalBobot = 0;

        foreach ($activity->initiatives as $init) {
            $lastReport = $init->reports->last();
            $progres = $lastReport ? $lastReport->actual : 0;
            $totalBobot += $init->weight;
            $totalProgresActivityUtama += ($init->weight / 100) * $progres;
        }

        dd($totalProgresActivityUtama);

    }
}