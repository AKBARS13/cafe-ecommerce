<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\CafeSetting;
use Illuminate\Http\Request;

class AdminCafeSettingController extends BaseController
{
    public function index()
    {
        $setting = CafeSetting::current();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'cafe_name' => 'required|string|max:255',
            'cafe_address' => 'nullable|string',
            'cafe_phone' => 'nullable|string|max:20',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'accept_reservation' => 'boolean',
            'reservation_start_time' => 'required|date_format:H:i',
            'reservation_end_time' => 'required|date_format:H:i',
            'max_reservation_days' => 'required|integer|min:1|max:30',
        ]);

        $validated['accept_reservation'] = $request->has('accept_reservation');

        $setting = CafeSetting::current();
        $setting->update($validated);

        return $this->successRedirect('admin.settings.index', 'Pengaturan cafe berhasil diupdate!');
    }
}