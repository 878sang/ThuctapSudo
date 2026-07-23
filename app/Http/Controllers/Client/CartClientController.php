<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CartServiceInterface;
use Illuminate\Http\Request;
use App\Services\Interfaces\UserAddressServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\CouponServiceInterface;

class CartClientController extends Controller
{
    protected CartServiceInterface $cartService;
    protected UserAddressServiceInterface $userAddressService;
    protected CouponServiceInterface $couponService;

    public function __construct(CartServiceInterface $cartService, UserAddressServiceInterface $userAddressService, CouponServiceInterface $couponService)
    {
        $this->userAddressService = $userAddressService;
        $this->cartService = $cartService;
        $this->couponService = $couponService;
    }

    public function cartClient()
    {
        $cartItems = $this->cartService->getCart('cart');
        $checkoutItems = $this->cartService->getCart();
        $totalPrice = $this->cartService->getTotalPrice();
        $defaultAddress = $this->userAddressService->getDefaultAddressForUser(Auth::id());

        $this->couponService->getAppliedCoupon($totalPrice);

        return view('client.cart.show', compact('cartItems', 'checkoutItems', 'totalPrice', 'defaultAddress'));
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

    public function buyNow(Request $request)
    {
        try {
            $this->cartService->buyNow($request->product_id, $request->quantity ?? 1);

            return redirect()->route('cart.showClient', ['mode' => 'buy_now']);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function applyCoupon(Request $request)
    {
        try {
            $code = $request->input('coupon_code');
            $totalPrice = $this->cartService->getTotalPrice();
            $result = $this->couponService->applyCoupon($code, $totalPrice, Auth::id());
            return response()->json([
                'success' => true,
                'message' => 'Áp dụng mã giảm giá thành công!',
                'discount_amount' => number_format($result['discount_amount'], 0, ',', '.') . ' đ',
                'new_total' => number_format($result['new_total'], 0, ',', '.') . ' đ',
                'coupon' => $result['coupon']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    public function removeCoupon()
    {
        $this->couponService->removeCoupon();
        $totalPrice = $this->cartService->getTotalPrice();
        return response()->json([
            'success' => true,
            'message' => 'Đã hủy mã giảm giá.',
            'total_price' => number_format($totalPrice, 0, ',', '.') . ' đ'
        ]);
    }
}
