<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceReport extends Model
{
    use HasFactory;
    protected $fillable = ['month', 'plan', 'actual', 'result_desc', 'problem_identification', 'corrective_action', 'initiative_id', 'user_id'];

    public function initiative() {
        return $this->belongsTo(Initiative::class);
    } 
}
