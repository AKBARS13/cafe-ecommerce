<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getItems();
        $total = $this->cartService->calculateTotal();
        $tax = $total * 0.1;
        $grandTotal = $total + $tax;

        return view('cart.index', compact('cartItems', 'total', 'tax', 'grandTotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            $this->cartService->addItem(
                $request->product_id,
                $request->quantity,
                $request->notes
            );
            return $this->successRedirect('cart.index', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return $this->errorRedirect('Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    public function update(Request $request, int $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        try {
            $this->cartService->updateItem($cartItemId, $request->quantity);
            return $this->successRedirect('cart.index', 'Keranjang berhasil diupdate!');
        } catch (\Exception $e) {
            return $this->errorRedirect('Gagal mengupdate keranjang: ' . $e->getMessage());
        }
    }

    public function remove(int $cartItemId)
    {
        try {
            $this->cartService->removeItem($cartItemId);
            return $this->successRedirect('cart.index', 'Item berhasil dihapus dari keranjang!');
        } catch (\Exception $e) {
            return $this->errorRedirect('Gagal menghapus item: ' . $e->getMessage());
        }
    }

    public function clear()
    {
        $this->cartService->clearCart();
        return $this->successRedirect('cart.index', 'Keranjang berhasil dikosongkan!');
    }
}