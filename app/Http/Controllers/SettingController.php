<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                'clinic_name' => 'CityCare Medical Centre',
                'currency' => 'UGX',
            ]);
        }

        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'clinic_email' => 'nullable|email',
            'clinic_phone' => 'nullable|string|max:20',
            'clinic_address' => 'nullable|string',
            'currency' => 'required|string|max:10',
        ]);

        $setting->update($request->only([
            'clinic_name',
            'clinic_email',
            'clinic_phone',
            'clinic_address',
            'currency',
        ]));

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}