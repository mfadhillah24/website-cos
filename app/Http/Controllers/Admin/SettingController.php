<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $this->authorize('manage_settings');
        
        // PASTIKAN SETTING KETUA SAMBUTAN ADA DI DATABASE
        Setting::firstOrCreate(
            ['key' => 'ketua_sambutan'],
            [
                'label' => 'Sambutan Ketua Umum',
                'type' => 'textarea',
                'group' => 'general',
                'value' => ''
            ]
        );
        
        $settings = Setting::all()->groupBy('group');
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->authorize('manage_settings');
        
        $settings = Setting::all();
        
        foreach ($settings as $setting) {
            $key = $setting->key;
            
            if ($setting->type === 'image') {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/settings'), $filename);
                    $path = 'settings/' . $filename;
                    
                    if ($setting->value && \Illuminate\Support\Facades\File::exists(public_path('images/' . $setting->value))) {
                        \Illuminate\Support\Facades\File::delete(public_path('images/' . $setting->value));
                    }
                    
                    $setting->update(['value' => $path]);
                }
            } else {
                if ($request->has($key)) {
                    $setting->update(['value' => $request->input($key)]);
                }
            }
        }
        
        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
