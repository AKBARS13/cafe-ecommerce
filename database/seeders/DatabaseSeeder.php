<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Cafe',
            'email' => 'admin@cafe.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Customer
        User::create([
            'name' => 'User',
            'email' => 'user@cafe.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567891',
        ]);

        // Categories
        $categories = [
            ['name' => 'Kopi', 'slug' => 'kopi', 'description' => 'Berbagai pilihan kopi nusantara', 'is_active' => true],
            ['name' => 'Non-Kopi', 'slug' => 'non-kopi', 'description' => 'Minuman selain kopi', 'is_active' => true],
            ['name' => 'Makanan', 'slug' => 'makanan', 'description' => 'Menu makanan berat dan ringan', 'is_active' => true],
            ['name' => 'Snack', 'slug' => 'snack', 'description' => 'Camilan pelengkap ngopi', 'is_active' => true],
            ['name' => 'Dessert', 'slug' => 'dessert', 'description' => 'Hidangan penutup manis', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Products
        $products = [
            // Kopi
            ['category_id' => 1, 'name' => 'Espresso', 'slug' => 'espresso', 'description' => 'Kopi espresso murni dengan rasa bold dan kaya', 'price' => 18000, 'stock' => 100, 'type' => 'drink', 'is_available' => true, 'is_featured' => true],
            ['category_id' => 1, 'name' => 'Cappuccino', 'slug' => 'cappuccino', 'description' => 'Perpaduan espresso, steamed milk, dan foam susu yang lembut', 'price' => 28000, 'stock' => 100, 'type' => 'drink', 'is_available' => true, 'is_featured' => true],
            ['category_id' => 1, 'name' => 'Cafe Latte', 'slug' => 'cafe-latte', 'description' => 'Espresso dengan susu steamed yang creamy', 'price' => 28000, 'stock' => 100, 'type' => 'drink', 'is_available' => true, 'is_featured' => true],
            ['category_id' => 1, 'name' => 'Americano', 'slug' => 'americano', 'description' => 'Espresso yang diencerkan dengan air panas', 'price' => 22000, 'stock' => 100, 'type' => 'drink', 'is_available' => true],
            ['category_id' => 1, 'name' => 'Kopi Susu Gula Aren', 'slug' => 'kopi-susu-gula-aren', 'description' => 'Es kopi susu dengan gula aren asli', 'price' => 25000, 'discount_price' => 22000, 'stock' => 100, 'type' => 'drink', 'is_available' => true, 'is_featured' => true],
            ['category_id' => 1, 'name' => 'Affogato', 'slug' => 'affogato', 'description' => 'Espresso panas dituang di atas es krim vanilla', 'price' => 32000, 'stock' => 50, 'type' => 'drink', 'is_available' => true],
            ['category_id' => 1, 'name' => 'Mocha Latte', 'slug' => 'mocha-latte', 'description' => 'Latte dengan tambahan cokelat premium', 'price' => 32000, 'stock' => 80, 'type' => 'drink', 'is_available' => true],

            // Non-Kopi
            ['category_id' => 2, 'name' => 'Matcha Latte', 'slug' => 'matcha-latte', 'description' => 'Green tea matcha premium dengan susu', 'price' => 30000, 'stock' => 80, 'type' => 'drink', 'is_available' => true, 'is_featured' => true],
            ['category_id' => 2, 'name' => 'Cokelat Panas', 'slug' => 'cokelat-panas', 'description' => 'Hot chocolate dari cokelat premium Belgia', 'price' => 28000, 'stock' => 80, 'type' => 'drink', 'is_available' => true],
            ['category_id' => 2, 'name' => 'Teh Tarik', 'slug' => 'teh-tarik', 'description' => 'Teh susu khas dengan rasa yang creamy', 'price' => 20000, 'stock' => 100, 'type' => 'drink', 'is_available' => true],
            ['category_id' => 2, 'name' => 'Lemon Tea', 'slug' => 'lemon-tea', 'description' => 'Teh segar dengan perasan lemon alami', 'price' => 18000, 'stock' => 100, 'type' => 'drink', 'is_available' => true],
            ['category_id' => 2, 'name' => 'Fresh Orange Juice', 'slug' => 'fresh-orange-juice', 'description' => 'Jus jeruk segar tanpa tambahan gula', 'price' => 25000, 'stock' => 60, 'type' => 'drink', 'is_available' => true],

            // Makanan
            ['category_id' => 3, 'name' => 'Nasi Goreng Spesial', 'slug' => 'nasi-goreng-spesial', 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar', 'price' => 35000, 'stock' => 50, 'type' => 'food', 'is_available' => true, 'is_featured' => true],
            ['category_id' => 3, 'name' => 'Chicken Sandwich', 'slug' => 'chicken-sandwich', 'description' => 'Sandwich ayam panggang dengan sayuran dan saus spesial', 'price' => 38000, 'discount_price' => 35000, 'stock' => 40, 'type' => 'food', 'is_available' => true],
            ['category_id' => 3, 'name' => 'Pasta Carbonara', 'slug' => 'pasta-carbonara', 'description' => 'Pasta creamy dengan saus carbonara dan bacon', 'price' => 42000, 'stock' => 30, 'type' => 'food', 'is_available' => true],
            ['category_id' => 3, 'name' => 'Beef Burger', 'slug' => 'beef-burger', 'description' => 'Burger daging sapi premium dengan keju dan sayuran', 'price' => 45000, 'stock' => 35, 'type' => 'food', 'is_available' => true],

            // Snack
            ['category_id' => 4, 'name' => 'French Fries', 'slug' => 'french-fries', 'description' => 'Kentang goreng renyah dengan saus pilihan', 'price' => 20000, 'stock' => 100, 'type' => 'snack', 'is_available' => true],
            ['category_id' => 4, 'name' => 'Roti Bakar', 'slug' => 'roti-bakar', 'description' => 'Roti bakar dengan berbagai topping', 'price' => 18000, 'stock' => 80, 'type' => 'snack', 'is_available' => true],
            ['category_id' => 4, 'name' => 'Pisang Goreng Keju', 'slug' => 'pisang-goreng-keju', 'description' => 'Pisang goreng crispy dengan taburan keju', 'price' => 22000, 'discount_price' => 18000, 'stock' => 60, 'type' => 'snack', 'is_available' => true],
            ['category_id' => 4, 'name' => 'Croissant', 'slug' => 'croissant', 'description' => 'Croissant butter yang flaky dan renyah', 'price' => 25000, 'stock' => 40, 'type' => 'snack', 'is_available' => true],

            // Dessert
            ['category_id' => 5, 'name' => 'Tiramisu', 'slug' => 'tiramisu', 'description' => 'Classic Italian tiramisu dengan mascarpone dan espresso', 'price' => 35000, 'stock' => 30, 'type' => 'dessert', 'is_available' => true, 'is_featured' => true],
            ['category_id' => 5, 'name' => 'Cheesecake', 'slug' => 'cheesecake', 'description' => 'New York style cheesecake yang lembut', 'price' => 35000, 'stock' => 25, 'type' => 'dessert', 'is_available' => true],
            ['category_id' => 5, 'name' => 'Brownies', 'slug' => 'brownies', 'description' => 'Chocolate brownies yang fudgy dan rich', 'price' => 28000, 'stock' => 40, 'type' => 'dessert', 'is_available' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Tambah Cafe Settings
        \App\Models\CafeSetting::create([
            'open_time' => '08:00:00',
            'close_time' => '22:00:00',
            'accept_reservation' => true,
            'reservation_start_time' => '00:00:00',
            'reservation_end_time' => '23:59:59',
            'max_reservation_days' => 7,
            'cafe_name' => 'Cafe Kopi Nusantara',
            'cafe_address' => 'Jl. Kopi No. 123, Jakarta',
            'cafe_phone' => '+62 812 3456 7890',
        ]);

        // Tambah Meja
        $tables = [
            ['table_number' => 'A1', 'capacity' => 2, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => 'A2', 'capacity' => 2, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => 'A3', 'capacity' => 4, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => 'A4', 'capacity' => 4, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => 'B1', 'capacity' => 6, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => 'B2', 'capacity' => 6, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => 'C1', 'capacity' => 4, 'location' => 'outdoor', 'status' => 'available'],
            ['table_number' => 'C2', 'capacity' => 4, 'location' => 'outdoor', 'status' => 'available'],
            ['table_number' => 'C3', 'capacity' => 8, 'location' => 'outdoor', 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            \App\Models\Table::create($table);
        }
    }
}