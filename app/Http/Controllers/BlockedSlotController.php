<?php

namespace App\Http\Controllers;

use App\Models\BlockedSlot;
use App\Models\Space;

use Illuminate\Http\Request;

use Inertia\Inertia;

class BlockedSlotController extends Controller
{
   

    public function index()
    {
        $blockedSlots = BlockedSlot::with('space')
            ->latest()
            ->get();

        return Inertia::render('BlockedSlots/Index', [

            'blockedSlots' => $blockedSlots,

            'spaces' => Space::all()

        ]);
    }

   

    public function store(Request $request)
    {
        $request->validate([

            'space_id' => 'required',

            'date' => 'required|date',

            'start_time' => 'required',

            'end_time' => 'required|after:start_time',

            'reason' => 'required'

        ]);

        BlockedSlot::create([

            'space_id' => $request->space_id,

            'date' => $request->date,

            'start_time' => $request->start_time,

            'end_time' => $request->end_time,

            'reason' => $request->reason

        ]);

        return back()->with(

            'success',
            'Horario bloqueado correctamente 🚫'

        );
    }

    

    public function destroy($id)
    {
        $blockedSlot = BlockedSlot::findOrFail($id);

        $blockedSlot->delete();

        return back()->with(

            'success',
            'Bloqueo eliminado 🗑️'

        );
    }
}