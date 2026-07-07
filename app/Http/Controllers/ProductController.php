<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    protected ProductServiceInterface $productService;
    protected CategoryServiceInterface $categoryService;
    public function __construct(ProductServiceInterface $productService, CategoryServiceInterface $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        $categories = $this->categoryService->getAll();
        $products = $this->productService->getFilteredProducts($request, 10);
        return view('Products.index', [
            'products' => ProductResource::collection($products),
            'categories' => $categories
        ]);
    }
    public function create()
    {
        $categories = $this->categoryService->getAll();
        return view('Products.create', compact('categories'));
    }
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $this->productService->create($data, $request);
        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }
    public function show(string $slug, string $id)
    {
        $product = $this->productService->findOrFail($id);
        return view('Products.detail', [
            'product' => new ProductResource($product)
        ]);
    }

    public function edit(string $id)
    {
        $product = $this->productService->findOrFail($id);
        $categories = $this->categoryService->getAll();
        return view('Products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $data = $request->validated();

        $this->productService->update($data, $request, $id);
        return redirect()->route('products.index')->with('success', 'Cập nhật thông tin sản phẩm thành công!');
    }

    public function restore(string $id)
    {
        $this->productService->restore($id);
        return redirect()->route('products.index')->with('success', 'Khôi phục sản phẩm thành công!');
    }
    public function destroy(string $id)
    {
        $this->productService->delete($id);
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
