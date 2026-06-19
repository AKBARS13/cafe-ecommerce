<?php

namespace App\Contracts;

interface CartInterface
{
    public function addItem(int $productId, int $quantity, ?string $notes = null): mixed;

    public function updateItem(int $cartItemId, int $quantity): mixed;

    public function removeItem(int $cartItemId): bool;

    public function clearCart(): bool;

    public function getItems(): mixed;

    public function calculateTotal(): float;
}