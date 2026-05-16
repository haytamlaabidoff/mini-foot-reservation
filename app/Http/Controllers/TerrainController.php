<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use App\Models\Sport;
use App\Models\SportFormat;
use Illuminate\Http\Request;

class TerrainController extends Controller
{
    /**
     * Display list
     */
    public function index()
    {
        $terrains = Terrain::with(['sport', 'sportFormat'])
            ->latest()
            ->get();

        return view('terrains.index', compact('terrains'));
    }

    /**
     * Create form
     */
    public function create()
    {
        $sports = Sport::all();
        $formats = SportFormat::with('sport')->get();

        return view('terrains.create', compact('sports', 'formats'));
    }

    /**
     * Store
     */

public function store(Request $request)
{
    $request->merge([
        'status' => $request->has('status'),
    ]);

    $request->validate([
        'name' => 'required|string|max:255',
        'sport_id' => 'required|exists:sports,id',
        'sport_format_id' => 'required|exists:sport_formats,id',
        'price_per_hour' => 'required|numeric|min:0',
        'number_of_days' => 'required|integer|min:1',
        'status' => 'boolean',
        'terrain_condition' => 'required|in:praticable,impraticable',
    ]);

    // 🔥 FIX IMPORTANT (plus fiable que find)
    $formatName = SportFormat::where('id', $request->sport_format_id)
        ->value('name');

    Terrain::create([
        'name' => $request->name,
        'sport_id' => $request->sport_id,
        'sport_format_id' => $request->sport_format_id,

        // 🔥 ICI ON FORCE LA VALEUR
        'format' => $formatName ?? null,

        'price_per_hour' => $request->price_per_hour,
        'number_of_days' => $request->number_of_days,
        'status' => $request->status,
        'terrain_condition' => $request->terrain_condition,
    ]);

    return redirect()->route('terrains.index')
        ->with('success', 'Terrain ajouté avec succès');
}

    /**
     * Show
     */
    public function show(Terrain $terrain)
    {
        $terrain->load(['sport', 'sportFormat']);

        return view('terrains.show', compact('terrain'));
    }

    /**
     * Edit form
     */
    public function edit(Terrain $terrain)
    {
        $sports = Sport::all();
        $formats = SportFormat::with('sport')->get();

        return view('terrains.edit', compact('terrain', 'sports', 'formats'));
    }

    /**
     * Update
     */
    public function update(Request $request, Terrain $terrain)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            // 🔥 relations
            'sport_id' => 'required|exists:sports,id',
            'sport_format_id' => 'required|exists:sport_formats,id',

            'price_per_hour' => 'required|numeric|min:0',
            'status' => 'nullable|boolean',
            'terrain_condition' => 'required|in:praticable,impraticable',
        ]);

        $terrain->update([
            'name' => $request->name,

            // 🔥 relations
            'sport_id' => $request->sport_id,
            'sport_format_id' => $request->sport_format_id,

            'price_per_hour' => $request->price_per_hour,
            'status' => $request->has('status') ? 1 : 0,
            'terrain_condition' => $request->terrain_condition,
        ]);

        return redirect()->route('terrains.index')
            ->with('success', 'Terrain modifié avec succès');
    }

    /**
     * Delete
     */
    public function destroy(Terrain $terrain)
    {
        $terrain->delete();

        return redirect()->route('terrains.index')
            ->with('success', 'Terrain supprimé avec succès');
    }

    /**
     * Toggle condition
     */
    public function toggleCondition(Terrain $terrain)
    {
        $terrain->terrain_condition =
            $terrain->terrain_condition === 'praticable'
            ? 'impraticable'
            : 'praticable';

        $terrain->save();

        return redirect()->back()
            ->with('success', 'État du terrain mis à jour');
    }
}