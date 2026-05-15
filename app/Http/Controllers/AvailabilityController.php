<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Models\Reservation;

use Inertia\Inertia;

class AvailabilityController extends Controller
{
   
    public function index()
    {
        $spaces = Space::all()->map(function ($space) {

            $activeReservation = Reservation::where('space_id', $space->id)
                ->where('date', now()->toDateString())
                ->where('status', 'approved')
                ->whereTime('start_time', '<=', now()->format('H:i:s'))
                ->whereTime('end_time', '>=', now()->format('H:i:s'))
                ->first();

            return [

                'id' => $space->id,

                'name' => $space->name,

                'location' => $space->location,

                'status' => $activeReservation
                    ? 'busy'
                    : 'available',

                'start_time' => $activeReservation?->start_time,

                'end_time' => $activeReservation?->end_time,

            ];

        });

        return Inertia::render('Realtime/Index', [

            'spaces' => $spaces

        ]);
    }
}