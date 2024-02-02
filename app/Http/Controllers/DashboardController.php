<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Divisi;
use App\Models\Initiative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    private string $wig = 'Wildly Important Goal (WIG)';
    private string $ig = 'Important Goal (IG)';
    
    public function index() {
        $actWIG = Activity::where('status', $this->wig)->whereYear('created_at', now()->year)->get();
        $actIG = Activity::where('status', $this->ig)->whereYear('created_at', now()->year)->get();
        $divisis = Divisi::where('id', '!=', 1)->get();
        $inits = Initiative::orderBy('activity_id')->get();
        
        $grandTotalProgres = 0;

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
            $grandTotalProgres += ($activity->weight / 100) * $progresActWIG[$activity->id]; 
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
            $grandTotalProgres += ($activity->weight / 100) * $progresActIG[$activity->id]; 
        }

        $data = [];

        foreach ($divisis as $div) {
            $uncomplete = 0;
            $complete = 0;
            $progres = 0;
            $total = 0;

            foreach ($div->users as $staff) {
                $total += optional($staff->initiatives)->count() ?? 0;

                foreach ($staff->initiatives as $init) {
                    if ($init->reports === null || $init->reports->last() === null) {
                        $uncomplete++;
                    } elseif ($init->reports->last()->actual == 100) {
                        $complete++;
                    } else {
                        $progres++;
                    }
                }
            }

            $data[] = [
                'divisi_name' => $div->name,
                'total_staff' => $div->users->count(),
                'total_task' => $total,
                'uncomplete' => $uncomplete,
                'complete' => $complete,
                'progress' => $progres,
            ];
        }

        // Staff task
        $tasks = [];
        $notYetTask = [];
        $staff = Auth::user();
        $complete = 0;
        foreach ($staff->initiatives as $init) {
            if ($init->reports->isEmpty()) {
                $notYetTask[] = $init;
            } else if (optional($init->reports->last())->actual == 100) {
                $complete++;
            }
        }

        $tasks = [
            'total' => $staff->initiatives->count(),
            'complete' => $complete,
        ];

        return view('dashboard', compact('actWIG', 'actIG', 'progresActWIG', 'progresActIG', 
        'grandTotalProgres', 'data', 'inits', 'tasks', 'notYetTask'));
    }

    public function donutChartDept() {
        $divisis = Divisi::where('id', '!=', 1)->get();

        foreach ($divisis as $div) {
            $uncomplete = 0;
            $complete = 0;
            $progres = 0;
            $total = 0;

            foreach ($div->users as $staff) {
                $total += optional($staff->initiatives)->count() ?? 0;

                foreach ($staff->initiatives as $init) {
                    if ($init->reports === null || $init->reports->last() === null) {
                        $uncomplete++;
                    } elseif ($init->reports->last()->actual == 100) {
                        $complete++;
                    } else {
                        $progres++;
                    }
                }
            }

            $data = [
                'series' => [$complete, $progres, $uncomplete],
            ];
        }

        return response()->json($data);
    }

    public function exportPdf() {
        $actWIG = Activity::where('status', $this->wig)->whereYear('created_at', now()->year)->get();
        $actIG = Activity::where('status', $this->ig)->whereYear('created_at', now()->year)->get();

        $grandTotalProgres = 0;

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
            $grandTotalProgres += ($activity->weight / 100) * $progresActWIG[$activity->id]; 
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
            $grandTotalProgres += ($activity->weight / 100) * $progresActIG[$activity->id]; 
        }

        // return view('export-chart', compact('actWIG', 'actIG', 'progresActWIG', 'progresActIG', 
        // 'grandTotalProgres'));

        $year = now()->format('Y');
        $pdf = Pdf::loadView('export-chart', compact('actWIG', 'actIG', 'progresActWIG', 'progresActIG', 
        'grandTotalProgres'));
        return $pdf->download('Scoreboard_'.$year.'.pdf');
    }

    public function countMyTask()
    {
        $user = Auth::user();
        $inits = Initiative::where('user_id', $user->id)->get();
        
        $completeTask = 0;
        $progresTask = 0;
        $notYetTask = 0;

        foreach ($inits as $init) {
            if ($init->reports === null || $init->reports->last() === null) {
                $notYetTask++;
            } elseif ($init->reports->last()->actual == 100) {
                $completeTask++;
            } else {
                $progresTask++;
            }
        }

        $data = [
            'series' => [$completeTask, $progresTask, $notYetTask],
        ];
        
        return response()->json($data);
    }

    public function getDataPerhitungan() {
        $divisis = Divisi::where('id', '!=', 1)->get();

        foreach ($divisis as $divisi) {
            $totaltask = 0;
            foreach ($divisi->users as $staff) {
                $totaltask = $staff->initiatives->count();
            }
            dd($totaltask);
        }
        
    }

    public function detailReportActivity($id) {
        $act = Activity::whereYear('created_at', now()->year)->findOrFail($id);
        $inits = Initiative::where('activity_id', $act->id)->get();

        return view('dashboard-detail-activity', compact('inits'));
    }
}
