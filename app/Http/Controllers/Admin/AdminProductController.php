<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Cloudinary\Cloudinary;

class AdminProductController extends BaseController
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

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'type' => 'required|in:food,drink,snack,dessert',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $cloudinary = $this->getCloudinary();
            $result = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'products']
            );
            $validated['image'] = $result['secure_url'];
        }

        Product::create($validated);

        return $this->successRedirect('admin.products.index', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'type' => 'required|in:food,drink,snack,dessert',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        // Hapus gambar jika checkbox remove_image dicentang
        if ($request->has('remove_image')) {
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            $cloudinary = $this->getCloudinary();
            $result = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'products']
            );
            $validated['image'] = $result['secure_url'];
        }

        $product->update($validated);

        return $this->successRedirect('admin.products.index', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->successRedirect('admin.products.index', 'Produk berhasil dihapus!');
    }
}