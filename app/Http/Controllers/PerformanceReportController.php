<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Initiative;
use App\Models\PerformanceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerformanceReportController extends Controller
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
            
            $planningSeries = []; // [20, 40]
            $actualSeries = []; // [20, 35]
            $monthxaxis = []; // ['Jan', 'Feb']

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
                'yaxis' => intval($init->target),
            ];
        }
        
        // dd($serverData);

        return response()->json($serverData);
    }

    public function getReportByActivity($activity_id)
    {
        $inits = Initiative::where('activity_id', $activity_id)->get();
        
        foreach ($inits as $init) {
            $reports = $init->reports->toArray();
            
            $planningSeries = []; // [20, 40]
            $actualSeries = []; // [20, 35]
            $monthxaxis = []; // ['Jan', 'Feb']

            foreach ($reports as $report) {
                $planningSeries[] = $report['plan'];
                $actualSeries[] = $report['actual'];
                $monthxaxis[] = $report['month'];
            }

            $alldata[] = [
                'series' => [
                    ['name' => 'Planning', 'data' => $planningSeries],
                    ['name' => 'Actual', 'data' => $actualSeries],
                ],
                'monthxaxis' => $monthxaxis,
                'yaxis' => intval($init->target),
            ];
        }

        return response()->json($alldata);
    }

    public function getDataWIG() {
        $acts = Activity::where('status', $this->wig)->whereYear('created_at', now()->year)->get();

        foreach ($acts as $act) {
            $planningSeries = []; // [20, 40]
            $actualSeries = []; // [20, 35]
            $monthxaxis = []; // ['Jan', 'Feb']
    
            foreach ($act->initiatives as $init) {
                $lastReport = $init->reports->last();
                $progres = $lastReport ? $lastReport->actual : 0;
                if ($init->target_type != 'Precentage') {
                    $progres = ($progres / $init->target) * 100;
                }
                $actualSeries[] = $progres;
                $planningSeries[] = 100;
                $monthxaxis[] = strlen($init->initiative) > 5 ? substr($init->initiative, 0, 5) . '..' : $init->initiative;
            }
    
            $dataig[] = [
                'series' => [
                    ['name' => 'Target', 'data' => $planningSeries],
                    ['name' => 'Progres', 'data' => $actualSeries],
                ],
                'monthxaxis' => $monthxaxis,
                'yaxis' => intval($act->target),
            ];
        }
        
        return response()->json($dataig);
    }

    public function getDataIG() {
        $acts = Activity::where('status', $this->ig)->whereYear('created_at', now()->year)->get();

        foreach ($acts as $act) {
            $planningSeries = []; // [20, 40]
            $actualSeries = []; // [20, 35]
            $monthxaxis = []; // ['Jan', 'Feb']
    
            foreach ($act->initiatives as $init) {
                $lastReport = $init->reports->last();
                $progres = $lastReport ? $lastReport->actual : 0;
                if ($init->target_type != 'Precentage') {
                    $progres = ($progres / $init->target) * 100;
                }
                $actualSeries[] = $progres;
                $planningSeries[] = 100;
                $monthxaxis[] = strlen($init->initiative) > 10 ? substr($init->initiative, 0, 10) . '...' : $init->initiative;
            }
    
            $datautama[] = [
                'series' => [
                    ['name' => 'Target', 'data' => $planningSeries],
                    ['name' => 'Progres', 'data' => $actualSeries],
                ],
                'monthxaxis' => $monthxaxis,
                'yaxis' => intval($act->target),
            ];
        }
        
        return response()->json($datautama);
    }

    public function getDataExportWIG($activity_id) {
        $act = Activity::where('status', $this->wig)->whereYear('created_at', now()->year)->findOrFail($activity_id);

        $datawig = [];
        foreach ($act->initiatives as $init) {
            $lastReport = $init->reports->last();
            $progres = $lastReport ? $lastReport->actual : 0;
            if ($init->target_type != 'Precentage') {
                $progres = ($progres / $init->target) * 100;
            }
            $datawig = [$init->initiative, 100, intval($progres)];
        }
        
        dd($datawig);
        return response()->json($datawig);
    }

    public function getDataExportIG() {
        $acts = Activity::where('status', $this->ig)->whereYear('created_at', now()->year)->get();

        foreach ($acts as $act) {
            $planningSeries = []; // [20, 40]
            $actualSeries = []; // [20, 35]
            $monthxaxis = []; // ['Jan', 'Feb']
    
            foreach ($act->initiatives as $init) {
                $lastReport = $init->reports->last();
                $progres = $lastReport ? $lastReport->actual : 0;
                if ($init->target_type != 'Precentage') {
                    $progres = ($progres / $init->target) * 100;
                }
                $actualSeries[] = $progres;
                $planningSeries[] = 100;
                $monthxaxis[] = strlen($init->initiative) > 10 ? substr($init->initiative, 0, 10) . '...' : $init->initiative;
            }
    
            $datautama[] = [
                'series' => [
                    ['name' => 'Target', 'data' => $planningSeries],
                    ['name' => 'Progres', 'data' => $actualSeries],
                ],
                'monthxaxis' => $monthxaxis,
                'yaxis' => intval($act->target),
            ];
        }
        
        return response()->json($datautama);
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
    public function store(Request $request, $initiative_id)
    {
        $user = Auth::user();
        $initiative = Initiative::findOrFail($initiative_id);
        try {
            
            $validatedData = $request->validate([
                'month' => 'required',
                'plan' => 'required|numeric',
                'actual' => 'required|numeric',
                'result_desc' => 'required',
                'problem_identification' => 'required',
                'corrective_action' => 'required',
                'file' => 'nullable',
            ]);
            
            $currentMonth = now()->format('M');
            if ($validatedData['month'] != $currentMonth) {
                return redirect(route('report.index'))->withErrors(['error' => 'Unable to create Report']);
            }

            if ($initiative->target_type == 'Precentage' && $validatedData['actual'] > 100) {
                return redirect(route('report.index'))->withErrors(['error' => 'Max target is 100%!']);
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $currentDateTime = now()->format('Ymd_His');
                $file_name = $user->npk . '_' . $currentDateTime . '_' .  $file->getClientOriginalName();
                $file->storeAs('report_file', $file_name);
                $validatedData['evidence_file'] = $file_name;
            } 

            $validatedData['user_id'] = $user->id;
            $validatedData['initiative_id'] = $initiative->id;
            
            $reqMonth = $validatedData['month']; 
            $lastReport = $initiative->reports->last();

            if ($lastReport && $lastReport->month != null) {
                $lastMonth = $lastReport->month;
            } else {
                $lastMonth = null;
            }

            if ($lastMonth != null && $reqMonth != 'Jan') {
                $monthMapping = [
                    'Jan' => 'Feb',
                    'Feb' => 'Mar',
                    'Mar' => 'Apr',
                    'Apr' => 'Mei',
                    'Mei' => 'Jun',
                    'Jun' => 'Jul',
                    'Jul' => 'Aug',
                    'Aug' => 'Sep',
                    'Sep' => 'Oct',
                    'Oct' => 'Nov',
                    'Nov' => 'Dec',
                ];
            
                if ($reqMonth == 'Dec' && $lastMonth != 'Nov') {
                    return redirect(route('report.index'))->withErrors(['error' => 'The report must be filled out every month! Do not forget to input PICA (Problem Identification & Corrective Action).']);
                }
            
                if ($reqMonth != $monthMapping[$lastMonth]) {
                    return redirect(route('report.index'))->withErrors(['error' => "The report must be filled out in the next month, which is {$monthMapping[$lastMonth]}. Do not forget to input PICA (Problem Identification & Corrective Action)."]);
                }
            }         

            PerformanceReport::create($validatedData);
    
            return redirect(route('report.index'))->with('success', 'Created Successfully');
        }catch (\Exception $e) {
            return redirect(route('report.index'))->withErrors(['error' => 'Failed to create: '.$e->getMessage()]);
        }  
    }

    public function uploadFile(Request $request, $id){
        $report = PerformanceReport::findOrFail($id);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $currentDateTime = now()->format('Ymd_His');
            $file_name = $report->user->npk . '_' . $currentDateTime . '_' .  $file->getClientOriginalName();
            $file->storeAs('report_file', $file_name);

            $report->evidence_file = $file_name;
            $report->save();
        } else {
            return redirect(route('report.index'))->withErrors(['error' => 'Failed to upload file...']);
        }
        return redirect(route('report.index'))->with('success', 'Upload file Successfully');
    }

    public function downloadFile($file){
        $path = '../storage/app/report_file/'.$file;
        return response()->download($path, $file);
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
        $report = PerformanceReport::findOrFail($id);
        $initiative = Initiative::findOrFail($report->initiative_id);
        $lastReport = $initiative->reports->last();

        if ($report != $lastReport) {
            return redirect(route('report.index'))->with('error', 'You can only delete reports from the last month');
        }
        
        $file_name = $report->evidence_file;

        if ($report->delete()) {
            if ($file_name && Storage::exists('report_file/' . $file_name)) {
                Storage::delete('report_file/' . $file_name);
            }

            return redirect(route('report.index'))->with('success', 'Deleted Successfully');
        }

        return redirect(route('report.index'))->with('error', 'Sorry, unable to delete this');
    }
}
