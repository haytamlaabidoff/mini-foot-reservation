<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SportController extends Controller
{
    public function index()
    {
        $sports = Sport::latest()->get();
        return view('sports.index', compact('sports'));
    }

    public function create()
    {
        return view('sports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Sport::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => true,
        ]);

        return redirect()->route('sports.index')
            ->with('success', 'Sport ajouté avec succès');
    }

    public function edit(Sport $sport)
    {
        return view('sports.edit', compact('sport'));
    }

    public function update(Request $request, Sport $sport)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $sport->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('sports.index')
            ->with('success', 'Sport modifié avec succès');
    }

    public function destroy(Sport $sport)
    {
        $sport->delete();

        return redirect()->route('sports.index')
            ->with('success', 'Sport supprimé avec succès');
    }
}