<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceReport extends Model
{
    use HasFactory;
    protected $fillable = ['progres', 'evidence_file', 'result_desc', 'target', 'initiative_id', 'user_id'];

    public function initiative() {
        return $this->belongsTo(Initiative::class);
    } 
}
