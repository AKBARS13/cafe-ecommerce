<?php

namespace App\Services;

use App\Contracts\CartInterface;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService implements CartInterface
{
    private ?Cart $cart;

    public function __construct()
    {
        $this->cart = null;
    }

    private function initCart(): Cart
    {
        if (!$this->cart) {
            $user = Auth::user();
            $this->cart = $user->getOrCreateCart();
        }
        return $this->cart;
    }

    public function addItem(int $productId, int $quantity, ?string $notes = null): mixed
    {
        $cart = $this->initCart();
        $product = Product::findOrFail($productId);

        $existingItem = $cart->items()->where('product_id', $productId)->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->subtotal = $existingItem->quantity * $existingItem->price;
            if ($notes) {
                $existingItem->notes = $notes;
            }
            $existingItem->save();
            $item = $existingItem;
        } else {
            $price = $product->final_price;
            $item = $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $price * $quantity,
                'notes' => $notes,
            ]);
        }

        $cart->recalculateTotal();
        return $item;
    }

    public function updateItem(int $cartItemId, int $quantity): mixed
    {
        $cart = $this->initCart();
        $item = CartItem::where('cart_id', $cart->id)->findOrFail($cartItemId);

        if ($quantity <= 0) {
            $item->delete();
        } else {
            $item->quantity = $quantity;
            $item->subtotal = $item->price * $quantity;
            $item->save();
        }

        $cart->recalculateTotal();
        return $item;
    }

    public function removeItem(int $cartItemId): bool
    {
        $cart = $this->initCart();
        $item = CartItem::where('cart_id', $cart->id)->findOrFail($cartItemId);
        $result = $item->delete();
        $cart->recalculateTotal();
        return $result;
    }

    public function clearCart(): bool
    {
        $cart = $this->initCart();
        $cart->items()->delete();
        $cart->update(['total_amount' => 0]);
        return true;
    }

    public function getItems(): mixed
    {
        $cart = $this->initCart();
        return $cart->items()->with('product')->get();
    }

    public function calculateTotal(): float
    {
        $cart = $this->initCart();
        return (float) $cart->items->sum('subtotal');
    }

    public function getCartItemCount(): int
    {
        $cart = $this->initCart();
        return $cart->items->sum('quantity');
    }
}