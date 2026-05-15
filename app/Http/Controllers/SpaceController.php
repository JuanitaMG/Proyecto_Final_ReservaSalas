<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SpaceController extends Controller
{
   
    public function index()
    {
        return Inertia::render('Spaces/Index', [

            'spaces' => Space::latest()->get()

        ]);
    }

    
    public function create()
    {
        return Inertia::render('Spaces/Create');
    }

    
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:255',
            'capacity' => 'required|integer',
            'description' => 'required',
            'price_per_hour' => 'nullable|numeric',

        ]);

        Space::create([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'capacity' => $request->capacity,

            'description' => $request->description,

            'price_per_hour' => $request->price_per_hour,

            'location' => $request->location,

            'is_active' => true,

        ]);

        return redirect('/spaces')
            ->with('success', 'Sala creada correctamente 🎉');
    }

    
    public function edit($id)
    {
        $space = Space::findOrFail($id);

        return Inertia::render('Spaces/Edit', [

            'space' => $space

        ]);
    }

   
    public function update(Request $request, $id)
    {
        $space = Space::findOrFail($id);

        $request->validate([

            'name' => 'required|max:255',
            'capacity' => 'required|integer',
            'description' => 'required',
            'price_per_hour' => 'nullable|numeric',

        ]);

        $space->update([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'capacity' => $request->capacity,

            'description' => $request->description,

            'price_per_hour' => $request->price_per_hour,

            'location' => $request->location,

            'is_active' => $request->is_active ?? true,

        ]);

        return redirect('/spaces')
            ->with('success', 'Sala actualizada correctamente ✨');
    }

   
    public function destroy($id)
    {
        $space = Space::findOrFail($id);

        $space->delete();

        return redirect('/spaces')
            ->with('success', 'Sala eliminada correctamente 🗑️');
    }
}