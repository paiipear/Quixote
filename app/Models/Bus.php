<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'license_plate',
        'capacity',
        'facilities',
        'description',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }   
    
}
