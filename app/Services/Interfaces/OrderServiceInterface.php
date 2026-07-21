<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\BaseServiceInterface;

interface OrderServiceInterface extends BaseServiceInterface
{
    public function cancelOrder(int $userId, int $orderId): bool;
}
