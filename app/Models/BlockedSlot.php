<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Space;

class BlockedSlot extends Model
{
    

    protected $fillable = [

        'space_id',
        'date',
        'start_time',
        'end_time',
        'reason',

    ];

    

    public function space()
    {
        return $this->belongsTo(Space::class);
    }
}