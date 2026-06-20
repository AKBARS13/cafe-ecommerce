<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Cloudinary\Cloudinary;

class AdminCategoryController extends BaseController
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
        $categories = Category::withCount('products')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $cloudinary = $this->getCloudinary();
            $result = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'categories']
            );
            $validated['image'] = $result['secure_url'];
        }

        Category::create($validated);

        return $this->successRedirect('admin.categories.index', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        // Hapus gambar jika checkbox remove_image dicentang
        if ($request->has('remove_image')) {
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            $cloudinary = $this->getCloudinary();
            $result = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'categories']
            );
            $validated['image'] = $result['secure_url'];
        }

        $category->update($validated);

        return $this->successRedirect('admin.categories.index', 'Kategori berhasil diupdate!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return $this->successRedirect('admin.categories.index', 'Kategori berhasil dihapus!');
    }
}