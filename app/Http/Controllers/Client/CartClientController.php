<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CartServiceInterface;
use Illuminate\Http\Request;

class CartClientController extends Controller
{
    protected CartServiceInterface $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function cartClient()
    {
        $cartItems = $this->cartService->getCart();
        $totalPrice = $this->cartService->getTotalPrice();

        return view('client.cart.show', compact('cartItems', 'totalPrice'));
    }
    public function add(Request $request)
    {
        try {
            $this->cartService->add($request->product_id, $request->quantity);
            return back()->with('success', 'Thêm vào giỏ hàng thành công');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function update(Request $request)
    {
        try {
            $this->cartService->update($request->product_id, $request->quantity);
            return back()->with('success', 'Cập nhật giỏ hàng thành công');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function remove(Request $request)
    {
        try {
            $this->cartService->remove(null, $request);
            return back()->with('success', 'Xóa giỏ hàng thành công');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
