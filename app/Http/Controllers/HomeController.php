<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index()
    {
        $featuredProducts = Product::available()->featured()->with('category')->take(8)->get();
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $latestProducts = Product::available()->with('category')->latest()->take(8)->get();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}