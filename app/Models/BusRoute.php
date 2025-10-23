<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusRoute extends Model
{
    use HasFactory;
    protected $table = 'routes'; // misal nama tabel kamu 'routes'

    protected $fillable = [
        'origin',
        'destination',
        'distance_km',  
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'route_id');
    }
}
