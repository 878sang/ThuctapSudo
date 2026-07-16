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
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm vào giỏ hàng thành công',
                    'cart_count' => $this->cartService->getCartCount()
                ]);
            }
            return back()->with('success', 'Thêm vào giỏ hàng thành công');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'cart_count' => $this->cartService->getCartCount(),
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }
    public function update(Request $request)
    {
        try {
            $updatedItem = $this->cartService->update($request->product_id, $request->quantity);
            if ($request->ajax() || $request->wantsJson()) {
                $itemSubtotal = $updatedItem['subtotal'] ?? 0;
                $totalPrice = $this->cartService->getTotalPrice();

                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật giỏ hàng thành công',
                    'cart_count' => $this->cartService->getCartCount(),
                    'item_subtotal' => number_format($itemSubtotal, 0, ',', '.') . ' đ',
                    'total_price' => number_format($totalPrice, 0, ',', '.') . ' đ'
                ]);
            }
            return back()->with('success', 'Cập nhật giỏ hàng thành công');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }
    public function remove(Request $request)
    {
        try {
            $this->cartService->remove(null, $request);
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa sản phẩm thành công',
                    'cart_count' => $this->cartService->getCartCount(),
                    'total_price' => number_format($this->cartService->getTotalPrice(), 0, ',', '.') . ' đ'
                ]);
            }
            return back()->with('success', 'Xóa sản phẩm thành công');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'cart_count' => $this->cartService->getCartCount(),
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }
}
