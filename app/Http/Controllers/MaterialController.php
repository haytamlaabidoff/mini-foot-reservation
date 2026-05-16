<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Material;
use App\Models\Terrain;
class MaterialController extends Controller
{
  public function index()
    {
        $materials = Material::with('terrain')
            ->latest()
            ->get();

        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $terrains = Terrain::all();

        return view('materials.create', compact('terrains'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'terrain_id' => 'required|exists:terrains,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required',
            'description' => 'nullable|string',
        ]);

        Material::create([

            'terrain_id' => $request->terrain_id,

            'name' => $request->name,

            'quantity' => $request->quantity,

            'condition' => $request->condition,

            'description' => $request->description,

        ]);

        return redirect()
            ->route('materials.index')
            ->with('success', '✅ Matériel ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $material = Material::with('terrain')->findOrFail($id);

        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $material = Material::findOrFail($id);

        $terrains = Terrain::all();

        return view('materials.edit', compact(
            'material',
            'terrains'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'terrain_id' => 'required|exists:terrains,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required',
            'description' => 'nullable|string',
        ]);

        $material->update([

            'terrain_id' => $request->terrain_id,

            'name' => $request->name,

            'quantity' => $request->quantity,

            'condition' => $request->condition,

            'description' => $request->description,

        ]);

        return redirect()
            ->route('materials.index')
            ->with('success', '✅ Matériel modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);

        $material->delete();

        return redirect()
            ->route('materials.index')
            ->with('success', '✅ Matériel supprimé');
    }
}
