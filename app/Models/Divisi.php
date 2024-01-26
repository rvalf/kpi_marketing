<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users() {
        return $this->hasMany(User::class);
    }

    // public function getDataPerhitungan()
    // {
    //     return $this->with(['users' => function ($query) {
    //             $query->select('id', 'divisi_id')
    //                 ->with(['initiatives' => function ($query) {
    //                     $query->select('id', 'user_id')
    //                         ->with(['performance_reports' => function ($query) {
    //                             $query->latest()->first();
    //                         }]);
    //                 }]);
    //         }])
    //         ->select('name')
    //         ->withCount([
    //             'users as total_initiatives',
    //             'users as total_kegiatan_selesai' => function ($query) {
    //                 $query->join('initiatives', 'initiatives.user_id', '=', 'users.id')
    //                     ->join('performance_reports', 'performance_reports.initiative_id', '=', 'initiatives.id')
    //                     ->where('performance_reports.actual', '=', 100);
    //             },
    //             'users as total_kegiatan_on_progress' => function ($query) {
    //                 $query->join('initiatives', 'initiatives.user_id', '=', 'users.id')
    //                     ->join('performance_reports', 'performance_reports.initiative_id', '=', 'initiatives.id')
    //                     ->where('performance_reports.actual', '>', 0);
    //             },
    //             'users as total_kegiatan_not_started' => function ($query) {
    //                 $query->leftJoin('initiatives', 'initiatives.user_id', '=', 'users.id')
    //                     ->leftJoin('performance_reports', function ($join) {
    //                         $join->on('performance_reports.initiative_id', '=', 'initiatives.id')
    //                             ->where('performance_reports.actual', '=', 0);
    //                     })
    //                     ->whereNull('performance_reports.id');
    //             },
    //         ])
    //         ->get();
    // }
}
