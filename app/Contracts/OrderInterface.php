<?php

namespace App\Contracts;

interface OrderInterface
{
    public function createOrder(array $data): mixed;

    public function updateOrderStatus(int $orderId, string $status): mixed;

    public function getOrdersByUser(int $userId): mixed;

    public function getOrderDetail(int $orderId): mixed;
}