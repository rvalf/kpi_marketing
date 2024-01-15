<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'objective', 'weight', 'target_type', 'target'];

    public static $_maxWeightWIG = 60;
    public static $_maxWeightIG = 40;

    public function initiatives() {
        return $this->hasMany(Initiative::class);
    }
}
