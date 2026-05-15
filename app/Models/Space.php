<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Availability;
use App\Models\BlockedSlot;
use App\Models\Reservation;

class Space extends Model
{
    

    protected $fillable = [

        'name',
        'slug',
        'capacity',
        'description',
        'price_per_hour',
        'is_active',

    ];

   

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

   

    public function blockedSlots()
    {
        return $this->hasMany(BlockedSlot::class);
    }
}