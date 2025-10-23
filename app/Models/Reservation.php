<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_id',
        'method',
        'amount',
        'status',
        'payment_proof',
        'paid_at',
    ];

    public function user() {
    return $this->belongsTo(User::class);
    }
    public function schedule() {
        return $this->belongsTo(Schedule::class,);
    }
    public function payment() {
        return $this->hasOne(Payment::class);
    }

}
