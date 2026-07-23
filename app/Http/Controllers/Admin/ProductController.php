<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Http\Resources\ProductResource;
use App\Services\Interfaces\BrandServiceInterface;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected ProductServiceInterface $productService;
    protected CategoryServiceInterface $categoryService;
    protected BrandServiceInterface $brandService;
    public function __construct(ProductServiceInterface $productService, CategoryServiceInterface $categoryService, BrandServiceInterface $brandService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
    }
    public function index(Request $request)
    {
        $categories = $this->categoryService->getActive();
        $brands = $this->brandService->getActive();
        $products = $this->productService->getFilteredProducts($request, 10);
        return view('admin.Products.index', [
            'products' => ProductResource::collection($products),
            'categories' => $categories,
            'brands' => $brands
        ]);
    }
    public function create()
    {
        $categories = $this->categoryService->getActive();
        $brands = $this->brandService->getActive();
        return view('admin.Products.create', compact('categories', 'brands'));
    }
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $this->productService->create($data);
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }
    public function show(string $slug, string $id)
    {
        $product = $this->productService->findOrFail($id);
        return view('admin.Products.detail', [
            'product' => new ProductResource($product)
        ]);
    }

    public function edit(string $id)
    {
        $product = $this->productService->findOrFail($id);
        $categories = $this->categoryService->getActive();
        $brands = $this->brandService->getActive();
        return view('admin.Products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $data = $request->validated();

        $this->productService->update($data, $id);
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật thông tin sản phẩm thành công!');
    }

    public function restore(string $id)
    {
        $this->productService->restore($id);
        return redirect()->route('admin.products.index')->with('success', 'Khôi phục sản phẩm thành công!');
    }
    public function destroy(string $id)
    {
        $this->productService->delete($id);
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
