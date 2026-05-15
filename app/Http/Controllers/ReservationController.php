<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\BlockedSlot;

use Illuminate\Http\Request;

use Inertia\Inertia;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusMail;

class ReservationController extends Controller
{
    

    public function index()
    {
        // 👑 ADMIN VE TODAS
        if (auth()->user()->role === 'admin') {

            $reservations = Reservation::with([
                'space',
                'user'
            ])
            ->latest()
            ->get();

        }

        
        else {

            $reservations = Reservation::with([
                'space',
                'user'
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        }

        return Inertia::render('Reservations/Index', [

            'reservations' => $reservations

        ]);
    }

    

    public function create(Request $request)
    {
        return Inertia::render('Reservations/Create', [

            'spaces' => Space::all(),

            'selectedDate' => $request->date

        ]);
    }

   

    public function checkAvailability(Request $request)
    {
        

        $reservationExists = Reservation::where('space_id', $request->space_id)

            ->where('date', $request->date)

            ->where(function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);

                });

            })

            ->exists();

       

        $blockedExists = BlockedSlot::where('space_id', $request->space_id)

            ->where('date', $request->date)

            ->where(function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);

                });

            })

            ->exists();

        return response()->json([

            'available' => !$reservationExists && !$blockedExists

        ]);
    }

   
    public function store(Request $request)
    {
        $request->validate([

            'space_id' => 'required',

            'date' => 'required|date',

            'start_time' => 'required',

            'end_time' => 'required|after:start_time',

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

            return back()->withErrors([

                'error' => 'Ese horario ya está reservado ❌'

            ]);

        }

        

        $blocked = BlockedSlot::where('space_id', $request->space_id)

            ->where('date', $request->date)

            ->where(function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);

                });

            })

            ->exists();

        if ($blocked) {

            return back()->withErrors([

                'error' => 'Ese horario está bloqueado 🚫'

            ]);

        }

       

        $reservation = Reservation::create([

            'user_id' => auth()->id(),

            'space_id' => $request->space_id,

            'date' => $request->date,

            'start_time' => $request->start_time,

            'end_time' => $request->end_time,

            'status' => 'pending',

        ]);

     

        Mail::to(auth()->user()->email)->send(

            new ReservationStatusMail(

                $reservation->load('space', 'user'),

                'Tu reserva fue creada correctamente y está pendiente de aprobación ⏳'

            )

        );

        return redirect('/reservations')
            ->with('success', 'Reserva creada correctamente 🎉');
    }

    

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);

       
        if (auth()->user()->role !== 'admin') {

            abort(403);

        }

        return Inertia::render('Reservations/Edit', [

            'reservation' => $reservation,

            'spaces' => Space::all()

        ]);
    }

   
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        
        if (auth()->user()->role !== 'admin') {

            abort(403);

        }

        

        $request->validate([

            'space_id' => 'required',

            'date' => 'required|date',

            'start_time' => 'required',

            'end_time' => 'required|after:start_time',

        ]);

        

        $exists = Reservation::where('space_id', $request->space_id)

            ->where('date', $request->date)

            ->where('id', '!=', $reservation->id)

            ->where(function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);

                });

            })

            ->exists();

        if ($exists) {

            return back()->withErrors([

                'error' => 'Ese horario ya está reservado ❌'

            ]);

        }

       

        $blocked = BlockedSlot::where('space_id', $request->space_id)

            ->where('date', $request->date)

            ->where(function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);

                });

            })

            ->exists();

        if ($blocked) {

            return back()->withErrors([

                'error' => 'Ese horario está bloqueado 🚫'

            ]);

        }

       

        $reservation->update([

            'space_id' => $request->space_id,

            'date' => $request->date,

            'start_time' => $request->start_time,

            'end_time' => $request->end_time,

        ]);

        return redirect('/reservations')
            ->with('success', 'Reserva actualizada ✨');
    }

    

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        
        if (auth()->user()->role !== 'admin') {

            abort(403);

        }

        $reservation->delete();

        return redirect('/reservations')
            ->with('success', 'Reserva eliminada 🗑️');
    }

    
    public function approve($id)
    {
        
        if (auth()->user()->role !== 'admin') {

            abort(403);

        }

        $reservation = Reservation::findOrFail($id);

        $reservation->update([

            'status' => 'approved'

        ]);

       
        Mail::to($reservation->user->email)->send(

            new ReservationStatusMail(

                $reservation->load('space', 'user'),

                'Tu reserva fue APROBADA ✅'

            )

        );

        return back()->with('success', 'Reserva aprobada ✅');
    }

    

    public function reject($id)
    {
        // 👑 SOLO ADMIN
        if (auth()->user()->role !== 'admin') {

            abort(403);

        }

        $reservation = Reservation::findOrFail($id);

        $reservation->update([

            'status' => 'rejected'

        ]);

        

        Mail::to($reservation->user->email)->send(

            new ReservationStatusMail(

                $reservation->load('space', 'user'),

                'Tu reserva fue RECHAZADA ❌'

            )

        );

        return back()->with('success', 'Reserva rechazada ❌');
    }

    

    public function cancel($id)
    {
        
        if (auth()->user()->role !== 'admin') {

            abort(403);

        }

        $reservation = Reservation::findOrFail($id);

        $reservation->update([

            'status' => 'cancelled'

        ]);

        

        Mail::to($reservation->user->email)->send(

            new ReservationStatusMail(

                $reservation->load('space', 'user'),

                'Tu reserva fue CANCELADA 🚫'

            )

        );

        return back()->with(

            'success',
            'Reserva cancelada 🚫'

        );
    }

    

    public function calendar()
    {
        
        if (!auth()->check()) {

            $reservations = Reservation::with('space')
                ->where('status', 'approved')
                ->latest()
                ->get();

        }

        
        elseif (auth()->user()->role === 'admin') {

            $reservations = Reservation::with([
                'space',
                'user'
            ])
            ->latest()
            ->get();

        }

        
        else {

            $reservations = Reservation::with('space')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();

        }

        return Inertia::render('Reservations/Calendar', [

            'reservations' => $reservations

        ]);
    }

    

    public function exportPdf()
    {
        
        if (auth()->user()->role === 'admin') {

            $reservations = Reservation::with([
                'space',
                'user'
            ])
            ->latest()
            ->get();

        }

        
        else {

            $reservations = Reservation::with([
                'space',
                'user'
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        }

        $pdf = Pdf::loadView(
            'pdf.reservations',
            [

                'reservations' => $reservations,

                'generatedBy' => auth()->user()->name,

                'totalReservations' => $reservations->count()

            ]
        );

        return $pdf->download('reservas.pdf');
    }
}