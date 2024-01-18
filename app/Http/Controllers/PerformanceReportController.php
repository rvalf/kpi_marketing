<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use App\Models\PerformanceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $inits = Initiative::where('user_id', $user->id)->get();
        return view('report.index', compact('inits'));
    }

    public function getData()
    {
        $user = Auth::user();
        $inits = Initiative::where('user_id', $user->id)->get();

        
        foreach ($inits as $init) {
            $reports = $init->reports->toArray();
            
            $planningSeries = [];
            $actualSeries = [];
            $monthxaxis = [];

            foreach ($reports as $report) {
                $planningSeries[] = $report['plan'];
                $actualSeries[] = $report['actual'];
                $monthxaxis[] = $report['month'];
            }

            $serverData[] = [
                'series' => [
                    ['name' => 'Planning', 'data' => $planningSeries],
                    ['name' => 'Actual', 'data' => $actualSeries],
                ],
                'monthxaxis' => $monthxaxis,
            ];
        }
        
        // $serverData =[
        //     [
        //         'series' => [
        //             ['name' => 'Earnings this month:', 'data' => [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120]],
        //             ['name' => 'Expense this month:', 'data' => [20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130]],
        //         ],
        //     ],
        //     [
        //         'series' => [
        //             ['name' => 'Earnings this month:', 'data' => [100, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120]],
        //             ['name' => 'Expense this month:', 'data' => [20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130]],
        //         ],
        //     ],
        // ];
        
        return response()->json($serverData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
