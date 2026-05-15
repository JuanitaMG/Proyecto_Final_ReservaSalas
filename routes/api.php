<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Space;
use App\Models\Reservation;

use App\Http\Controllers\ReservationController;


Route::get('/user', function (Request $request) {

    return $request->user();

})->middleware('auth:sanctum');



Route::get('/spaces', function () {

    return Space::all();

});


Route::get('/reservations', function () {

    return Reservation::with([
        'space',
        'user'
    ])->get();

});



Route::post('/reservations', function (Request $request) {

    

    $request->validate([

        'space_id' => 'required',

        'date' => 'required|date',

        'start_time' => 'required',

        'end_time' => 'required|after:start_time'

    ]);

    
    $exists = Reservation::where('space_id', $request->space_id)

        ->where('date', $request->date)

        ->where(function ($query) use ($request) {

            $query->where(function ($q) use ($request) {

                $q->where('start_time', '<', $request->end_time)
                  ->where('end_time', '>', $request->start_time);

            });

        })

        ->exists();

   
    if ($exists) {

        return response()->json([

            'message' => 'Ese horario ya está reservado ❌'

        ], 422);

    }

    

    $reservation = Reservation::create([

        'user_id' => 1,

        'space_id' => $request->space_id,

        'date' => $request->date,

        'start_time' => $request->start_time,

        'end_time' => $request->end_time,

        'status' => 'pending'

    ]);

    

    return response()->json([

        'message' => 'Reserva creada correctamente 🎉',

        'reservation' => $reservation

    ]);

});



Route::put('/reservations/{id}', function (Request $request, $id) {

    $reservation = Reservation::findOrFail($id);

    

    $request->validate([

        'space_id' => 'required',

        'date' => 'required|date',

        'start_time' => 'required',

        'end_time' => 'required|after:start_time'

    ]);

   

    $reservation->update([

        'space_id' => $request->space_id,

        'date' => $request->date,

        'start_time' => $request->start_time,

        'end_time' => $request->end_time

    ]);

    return response()->json([

        'message' => 'Reserva actualizada correctamente ✨',

        'reservation' => $reservation

    ]);

});



Route::delete('/reservations/{id}', function ($id) {

    $reservation = Reservation::findOrFail($id);

    $reservation->delete();

    return response()->json([

        'message' => 'Reserva eliminada correctamente 🗑️'

    ]);

});



Route::post('/reservations/{id}/approve', function ($id) {

    $reservation = Reservation::findOrFail($id);

    $reservation->update([

        'status' => 'approved'

    ]);

    return response()->json([

        'message' => 'Reserva aprobada ✅',

        'reservation' => $reservation

    ]);

});



Route::post('/reservations/{id}/reject', function ($id) {

    $reservation = Reservation::findOrFail($id);

    $reservation->update([

        'status' => 'rejected'

    ]);

    return response()->json([

        'message' => 'Reserva rechazada ❌',

        'reservation' => $reservation

    ]);

});