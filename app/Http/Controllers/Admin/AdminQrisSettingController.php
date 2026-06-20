<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\CafeSetting;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;

class AdminQrisSettingController extends BaseController
{
    private function getCloudinary()
    {
        return new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dohbxopsh',
                'api_key' => '619143837518466',
                'api_secret' => 'mL7LUpRY7_OljTEUbj-0pJiqxQw',
            ],
            'url' => [
                'secure' => true,
            ],
        ]);
    }

    public function index()
    {
        $setting = CafeSetting::current();
        return view('admin.payment-settings.qris.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'qris_merchant_name' => 'nullable|string|max:255',
            'qris_instructions' => 'nullable|string|max:500',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'qris_enabled' => 'boolean',
            'remove_qris' => 'boolean',
        ]);

        $setting = CafeSetting::current();

        $dataToUpdate = [
            'qris_merchant_name' => $request->qris_merchant_name,
            'qris_instructions' => $request->qris_instructions,
            'qris_enabled' => $request->has('qris_enabled'),
        ];

        // Hapus QRIS image jika dicentang
        if ($request->has('remove_qris')) {
            $dataToUpdate['qris_image'] = null;
        }

        // Upload QRIS image baru
        if ($request->hasFile('qris_image')) {
            $cloudinary = $this->getCloudinary();
            $result = $cloudinary->uploadApi()->upload(
                $request->file('qris_image')->getRealPath(),
                ['folder' => 'qris']
            );
            $dataToUpdate['qris_image'] = $result['secure_url'];
        }

        $setting->update($dataToUpdate);

        return $this->successRedirect('admin.qris.index', 'Pengaturan QRIS berhasil diupdate!');
    }
}