<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;

class GeneralSettingController extends Controller
{
    /**
     * عرض الفورم
     */
    public function index()
    {
        $setting = GeneralSetting::first();

        return view('admin.settings', compact('setting'));
    }
    public function show()
{
    $setting = \App\Models\GeneralSetting::first();

    return view('admin.settings-index', compact('setting'));
}

    /**
     * حفظ البيانات
     */
    public function store(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'map_link' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $setting = GeneralSetting::first();

        // 📸 upload logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        } else {
            $logoPath = $setting->logo ?? null;
        }

        GeneralSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => $request->site_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'map_link' => $request->map_link,
                'logo' => $logoPath,
            ]
        );

          return view('admin.settings-index', compact('setting'))->with('success', '✅ Settings mis à jour');
    }
}