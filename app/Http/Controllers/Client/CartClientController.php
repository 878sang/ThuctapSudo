<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class CartClientController extends Controller
{
    public function cartClient()
    {
        $cartItems = [
            [
                'id' => 1,
                'name' => 'Cầu dao tự động dạng cài SIEMENS 5SQ60N3M2',
                'price' => '150.000',
                'quantity' => 1,
                'stars' => 4,
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'id' => 2,
                'name' => 'Cầu dao tự động dạng cài SIEMENS 5SQ60N3M2',
                'price' => '150.000',
                'quantity' => 1,
                'stars' => 4,
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'id' => 3,
                'name' => 'Cầu dao tự động dạng cài SIEMENS 5SQ60N3M2',
                'price' => '150.000',
                'quantity' => 1,
                'stars' => 4,
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'id' => 4,
                'name' => 'Cầu dao tự động dạng cài SIEMENS 5SQ60N3M2',
                'price' => '150.000',
                'quantity' => 1,
                'stars' => 4,
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'id' => 5,
                'name' => 'Cầu dao tự động dạng cài SIEMENS 5SQ60N3M2',
                'price' => '150.000',
                'quantity' => 1,
                'stars' => 4,
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'id' => 6,
                'name' => 'Cầu dao tự động dạng cài SIEMENS 5SQ60N3M2',
                'price' => '150.000',
                'quantity' => 1,
                'stars' => 4,
                'image' => 'storage/images/chitiet1.jpg',
            ],
        ];

        return view('client.cart.show', compact('cartItems'));
    }
}
