<?php

namespace App\Services;

use App\Services\Interfaces\CartServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class CartService implements CartServiceInterface
{
    protected ProductRepositoryInterface $productRepository;
    protected string $cartKey = 'cart';
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function getCart()
    {
        $cart = session()->get($this->cartKey, []);
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
        $cart = session()->get($this->cartKey, []);
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
        session()->put($this->cartKey, $cart);
    }
    public function update(int $id, int $quantity)
    {
        $product = $this->productRepository->findOrFail($id);
        $cart = session()->get($this->cartKey, []);
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
        session()->put($this->cartKey, $cart);

        return $cart[$id];
    }
    public function remove(?int $id = null, ?Request $request = null)
    {
        $cart = session()->get($this->cartKey, []);
        if ($request && $request->has('product_ids')) {
            $ids = explode(',', $request->product_ids);
            foreach ($ids as $id) {
                unset($cart[$id]);
            }
            session()->put($this->cartKey, $cart);
            return back()->with('success', 'Xóa sản phẩm đã chọn thành công');
        } else {
            if (!isset($cart[$id])) {
                throw new \Exception('Sản phẩm không có trong giỏ hàng');
            }
            unset($cart[$id]);
            session()->put($this->cartKey, $cart);
            return back()->with('success', 'Xóa giỏ hàng thành công');
        }
    }
    public function clear()
    {
        session()->forget($this->cartKey);
    }
    public function getCartCount()
    {
        $cart = session()->get($this->cartKey, []);
        return array_sum(array_column($cart, 'quantity'));
    }
    public function getTotalPrice()
    {
        $cart = session()->get($this->cartKey, []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        return $total;
    }
}
