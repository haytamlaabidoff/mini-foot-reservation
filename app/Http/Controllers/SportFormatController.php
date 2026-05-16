<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use App\Models\SportFormat;
use Illuminate\Http\Request;

class SportFormatController extends Controller
{
    public function index()
    {
        $formats = SportFormat::with('sport')->latest()->get();
        return view('sport_formats.index', compact('formats'));
    }

    public function create()
    {
        $sports = Sport::all();
        return view('sport_formats.create', compact('sports'));
    }

    // 🔥 FUNCTION TO GENERATE FORMAT NAME
    private function generateFormat($players)
    {
        if ($players == 2) return 'Simple';
        if ($players == 4) return 'Double';

        $half = $players / 2;

        return $half . 'v' . $half;
    }

    public function store(Request $request)
    {
        $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'players_count' => 'required|integer|min:1',
            'duration' => 'nullable|integer',
            'default_price' => 'nullable|numeric',
        ]);

        // 🔥 auto generate name
        $formatName = $this->generateFormat($request->players_count);

        SportFormat::create([
            'sport_id' => $request->sport_id,
            'name' => $formatName,
            'players_count' => $request->players_count,
            'duration' => $request->duration ?? 60,
            'default_price' => $request->default_price,
            'status' => true,
        ]);

        return redirect()->route('sport-formats.index')
            ->with('success', 'Format créé automatiquement avec succès');
    }

    public function edit(SportFormat $sportFormat)
    {
        $sports = Sport::all();
        return view('sport_formats.edit', compact('sportFormat', 'sports'));
    }

    public function update(Request $request, SportFormat $sportFormat)
    {
        $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'players_count' => 'required|integer|min:1',
            'duration' => 'nullable|integer',
            'default_price' => 'nullable|numeric',
        ]);

        // 🔥 regenerate name
        $formatName = $this->generateFormat($request->players_count);

        $sportFormat->update([
            'sport_id' => $request->sport_id,
            'name' => $formatName,
            'players_count' => $request->players_count,
            'duration' => $request->duration,
            'default_price' => $request->default_price,
        ]);

        return redirect()->route('sport-formats.index')
            ->with('success', 'Format modifié avec succès');
    }

    public function destroy(SportFormat $sportFormat)
    {
        $sportFormat->delete();

        return redirect()->route('sport-formats.index')
            ->with('success', 'Format supprimé avec succès');
    }
    public function show($sportId)
{
    return \App\Models\SportFormat::where('sport_id', $sportId)
        ->get(['id', 'name', 'players_count']);
}
}