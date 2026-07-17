<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\BrandServiceInterface;
use App\Services\Interfaces\ReviewServiceInterface;
use Illuminate\Http\Request;

class ProductClientController extends Controller
{
    protected ProductServiceInterface $productService;
    protected CategoryServiceInterface $categoryService;
    protected BrandServiceInterface $brandService;
    protected ReviewServiceInterface $reviewService;

    public function __construct(
        ProductServiceInterface $productService,
        CategoryServiceInterface $categoryService,
        BrandServiceInterface $brandService,
        ReviewServiceInterface $reviewService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->reviewService = $reviewService;
    }
    public function showClient(Request $request)
    {
        $products = $this->productService->getFilteredProducts($request);
        $categories = $this->categoryService->getActiveWithChildren();
        $brands = $this->brandService->getActive();
        $selectedCategory = $request->category ? $this->categoryService->with(['parent'])->find((int)$request->category) : null;
        $selectedBrand = $brands->find($request->brand);
        return view('client.products.show', compact('products', 'categories', 'brands', 'selectedCategory', 'selectedBrand'));
    }
    public function productDetailClient($slug, $id)
    {
        $product = $this->productService->with(['category', 'specifications'])->findOrFail($id);
        $seriesProducts = $this->productService->getProductsByCategory($product->category_id);
        $relatedProducts = $this->productService->getProductsByBrand($product->brand_id, $product->id, 6);

        $reviewData = $this->reviewService->getReviewDetailsByProductId($id);

        return view('client.products.detail', compact('product', 'seriesProducts', 'relatedProducts', 'reviewData'));
    }
}
