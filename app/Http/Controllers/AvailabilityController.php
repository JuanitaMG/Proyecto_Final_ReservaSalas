<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Space;
use App\Models\Reservation;

use Illuminate\Http\Request;

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

            

            $nextReservation = Reservation::where('space_id', $space->id)

                ->where('date', now()->toDateString())

                ->where('status', 'approved')

                ->whereTime('start_time', '>', now()->format('H:i:s'))

                ->whereTime(
                    'start_time',
                    '<=',
                    now()->copy()->addMinutes(30)->format('H:i:s')
                )

                ->first();

           

            $status = 'available';

            // SALA INACTIVA
            if (!$space->is_active) {

                $status = 'inactive';

            }

            // SALA OCUPADA
            elseif ($activeReservation) {

                $status = 'busy';

            }

            // PRÓXIMA RESERVA
            elseif ($nextReservation) {

                $status = 'soon';

            }

            

            return [

                'id' => $space->id,

                'name' => $space->name,

                'location' => $space->location,

                // IMAGEN
                'image' => $space->image,

                // STATUS
                'status' => $status,

                // HORARIOS
                'start_time' => $activeReservation?->start_time
                    ?? $nextReservation?->start_time,

                'end_time' => $activeReservation?->end_time
                    ?? $nextReservation?->end_time,

            ];

        });

    

        $availabilities = Availability::with('space')
            ->latest()
            ->get();

       

        return Inertia::render('Realtime/Index', [

            'spaces' => $spaces,

            'availabilities' => $availabilities,

            'allSpaces' => Space::orderBy('name')->get()

        ]);
    }

    

    public function store(Request $request)
    {

        $request->validate([

            'space_id' => 'required|exists:spaces,id',

            'day_of_week' => 'required|integer|min:0|max:6',

            'start_time' => 'required',

            'end_time' => 'required|after:start_time',

        ]);

        Availability::create([

            'space_id' => $request->space_id,

            'day_of_week' => $request->day_of_week,

            'start_time' => $request->start_time,

            'end_time' => $request->end_time,

        ]);

        return back()->with(

            'success',
            'Disponibilidad creada correctamente ⏰'

        );
    }

   

    public function destroy($id)
    {

        $availability = Availability::findOrFail($id);

        $availability->delete();

        return back()->with(

            'success',
            'Disponibilidad eliminada 🗑️'

        );
    }
}