<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Initiative extends Model
{
    use HasFactory;

    protected $fillable = ['initiative', 'weight', 'target_type', 'target', 'activity_id', 'user_id'];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }    

    public function user() {
        return $this->belongsTo(User::class);
    }    
}
