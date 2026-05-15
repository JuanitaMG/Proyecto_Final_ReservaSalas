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

 

    public function show($slug)
    {
        $space = Space::where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('Spaces/Show', [

            'space' => $space

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

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);

       
        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('spaces', 'public');

        }

       

        Space::create([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'capacity' => $request->capacity,

            'description' => $request->description,

            'price_per_hour' => $request->price_per_hour,

            'location' => $request->location,

            'image' => $imagePath,

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

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);

        

        $imagePath = $space->image;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('spaces', 'public');

        }

        

        $space->update([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'capacity' => $request->capacity,

            'description' => $request->description,

            'price_per_hour' => $request->price_per_hour,

            'location' => $request->location,

            'image' => $imagePath,

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