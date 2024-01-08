<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'objective', 'weight', 'target_type', 'target'];

    public function initiatives() {
        return $this->hasMany(Initiative::class);
    }
}
