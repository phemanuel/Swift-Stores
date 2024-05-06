<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('settings.edit', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        if ($request->hasFile('avatar')) {
            $avatar_path = $request->file('avatar')->store('settings', 'public');
            $data['avatar'] = $avatar_path;
        }           
        
        foreach ($data as $key => $value) {
            $setting = Setting::firstOrCreate(['key' => $key]);
            $setting->value = $value;          
            $setting->save();
        }

        return redirect()->route('settings.index');
    }
}
