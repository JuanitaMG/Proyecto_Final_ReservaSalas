<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Space;

class Availability extends Model
{
   

    protected $fillable = [

        'space_id',
        'day_of_week',
        'start_time',
        'end_time',

    ];

    

    public function space()
    {
        return $this->belongsTo(Space::class);
    }
}