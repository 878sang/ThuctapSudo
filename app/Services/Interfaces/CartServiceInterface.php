<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;


interface CartServiceInterface
{
    public function getCart(?string $key = null);
    public function add(int $id, int $quantity);
    public function update(int $id, int $quantity);
    public function remove(?int $id = null, ?Request $request = null);
    public function clear();
    public function getCartCount();
    public function getTotalPrice();
    public function getCartKey();
    public function buyNow(int $productId, int $quantity);
}
