<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::where('group', 'general')->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function group(string $group)
    {
        if ($group == 'sponsor') return redirect()->route('admin.sponsors.index');
        if ($group == 'infographics') return redirect()->route('admin.infographics.index');
        
        $settings = Setting::where('group', $group)->pluck('value', 'key');
        return view('admin.settings.group', compact('settings', 'group'));
    }

    public function update(Request $request)
    {
        $group = $request->input('group', 'general');

        // Handle dynamic Sertifikasi Lainnya (array of name + file)
        if ($request->has('cert_other_name')) {
            $names = $request->input('cert_other_name', []);
            $files = $request->file('cert_other_file', []);
            $keepPaths = $request->input('cert_other_existing', []);

            // Load existing stored certs to preserve unchanged file paths
            $existing = json_decode(Setting::get('cert_others', '[]'), true) ?? [];

            $certs = [];
            foreach ($names as $i => $name) {
                if (empty(trim($name)))
                    continue;

                // New file uploaded for this index?
                if (!empty($files[$i]) && $files[$i]->isValid()) {
                    $path = $files[$i]->store('settings/certs', 'public');
                }
                else {
                    // Keep existing path if available
                    $path = $keepPaths[$i] ?? ($existing[$i]['file'] ?? null);
                }

                $certs[] = ['name' => trim($name), 'file' => $path];
            }

            Setting::set('cert_others', json_encode($certs));
            Setting::where('key', 'cert_others')->update(['group' => $group]);
        }

        // Process all other regular settings (skip cert_other_* arrays)
        $skip = ['_token', 'group', 'cert_other_name', 'cert_other_file', 'cert_other_existing'];
        
        // Handle specific file deletions
        foreach ($request->all() as $reqKey => $reqValue) {
            if (str_starts_with($reqKey, 'delete_') && $reqValue == '1') {
                $settingKey = str_replace('delete_', '', $reqKey);
                $oldPath = Setting::get($settingKey);
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                Setting::set($settingKey, null);
                $skip[] = $reqKey; // Skip this from the main loop
                $skip[] = $settingKey; // Also skip the original key if it's in the request (it shouldn't be for files, but just in case)
            }
        }

        foreach ($request->except($skip) as $key => $value) {
            if ($request->hasFile($key)) {
                // Delete old file if exists
                $oldPath = Setting::get($key);
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                
                $path = $request->file($key)->store('settings', 'public');
                Setting::set($key, $path);
            }
            else {
                Setting::set($key, $value);
            }
            Setting::where('key', $key)->update(['group' => $group]);
        }

        Cache::forget('site_settings');

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
