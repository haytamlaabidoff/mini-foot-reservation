<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkingHour;

class WorkingHourController extends Controller
{
    public function index()
    {
        $hours = WorkingHour::latest()->get();
        return view('working_hours.index', compact('hours'));
    }

    public function create()
    {
        return view('working_hours.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'days' => 'required|array',
            'open_time' => 'nullable',
            'close_time' => 'nullable',
            'note' => 'nullable|string',
        ]);

        WorkingHour::create([
            'days' => $request->days,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'note' => $request->note,
            'is_closed' => $request->has('is_closed'),
        ]);

        return redirect()->route('working-hours.index')
            ->with('success', 'Working hour created successfully');
    }

    public function edit($id)
    {
        $hour = WorkingHour::findOrFail($id);
        return view('working_hours.edit', compact('hour'));
    }

    public function update(Request $request, $id)
    {
        $hour = WorkingHour::findOrFail($id);

        $hour->update([
            'days' => $request->days,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'note' => $request->note,
            'is_closed' => $request->has('is_closed'),
        ]);

        return redirect()->route('working-hours.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        WorkingHour::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully');
    }
}