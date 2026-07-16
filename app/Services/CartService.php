<?php

namespace App\Services;

use App\Services\Interfaces\CartServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class CartService implements CartServiceInterface
{
    protected ProductRepositoryInterface $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function getCartKey()
    {
        if (request()->routeIs('cart.showClient', 'checkout.placeOrder', 'checkout.validate') &&
            request()->get('mode') === 'buy_now'
        ) {
            return 'buy_now_cart';
        }
        return 'cart';
    }
    public function getCart(?string $key = null)
    {
        $cartKey = $key ?: $this->getCartKey();
        $cart = session()->get($cartKey, []);
        if (empty($cart)) {
            return [];
        }
        $productIds = array_keys($cart);
        $products = $this->productRepository->whereIn('id', $productIds)->get();
        $cartData = [];
        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'];
            $price = $product->sale_price ?? $product->price;
            $cartData[$product->id] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $price * $quantity,
                'stars' => 5,
            ];
        }
        return $cartData;
    }
    public function add(int $id, int $quantity)
    {
        $product = $this->productRepository->findOrFail($id);
        $cart = session()->get($this->getCartKey(), []);
        $price = $product->sale_price ?? $product->price;
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
            $cart[$id]['subtotal'] = $price * $cart[$id]['quantity'];
        } else {
            $cart[$id] = [
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $price * $quantity,
            ];
        }
        if ($cart[$id]['quantity'] > $product->stock) {
            throw new \Exception('Số lượng vượt quá số lượng trong kho');
        }
        session()->put($this->getCartKey(), $cart);
    }
    public function update(int $id, int $quantity)
    {
        $product = $this->productRepository->findOrFail($id);
        $cart = session()->get($this->getCartKey(), []);
        if ($quantity <= 0) {
            $this->remove($id);
            return [];
        }
        if (!isset($cart[$id])) {
            throw new \Exception('Sản phẩm không có trong giỏ hàng');
        }
        if ($quantity > $product->stock) {
            throw new \Exception('Số lượng vượt quá số lượng trong kho');
        }
        $price = $product->sale_price ?? $product->price;
        $cart[$id]['quantity'] = $quantity;
        $cart[$id]['subtotal'] = $price * $quantity;
        session()->put($this->getCartKey(), $cart);

        return $cart[$id];
    }
    public function remove(?int $id = null, ?Request $request = null)
    {
        $cart = session()->get($this->getCartKey(), []);
        if ($request && $request->has('product_ids')) {
            $ids = explode(',', $request->product_ids);
            foreach ($ids as $id) {
                unset($cart[$id]);
            }
            session()->put($this->getCartKey(), $cart);
            return back()->with('success', 'Xóa sản phẩm đã chọn thành công');
        } else {
            if (!isset($cart[$id])) {
                throw new \Exception('Sản phẩm không có trong giỏ hàng');
            }
            unset($cart[$id]);
            session()->put($this->getCartKey(), $cart);
            return back()->with('success', 'Xóa giỏ hàng thành công');
        }
    }
    public function clear()
    {
        session()->forget($this->getCartKey());
    }
    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
    public function getTotalPrice()
    {
        $cart = session()->get($this->getCartKey(), []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        return $total;
    }
    public function buyNow(int $productId, int $quantity)
    {
        $product = $this->productRepository->findOrFail($productId);
        
        if ($quantity > $product->stock) {
            throw new \Exception('Số lượng vượt quá số lượng trong kho');
        }

        $price = $product->sale_price ?? $product->price;

        session()->put('buy_now_cart', [
            $productId => [
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $price * $quantity,
            ]
        ]);
    }
}
