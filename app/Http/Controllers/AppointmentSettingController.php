<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSetting;
use Illuminate\Http\Request;

class AppointmentSettingController extends Controller
{
    public function index()
    {
        $setting = AppointmentSetting::first();
        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'max_appointments' => 'required|integer|min:1'
        ]);

        $setting = AppointmentSetting::first();
        if (!$setting) {
            $setting = new AppointmentSetting();
        }

        $setting->max_appointments = $request->max_appointments;
        $setting->save();

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
