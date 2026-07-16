<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\BrandServiceInterface;
use Illuminate\Http\Request;

class ProductClientController extends Controller
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
    public function showClient(Request $request)
    {
        $products = $this->productService->getFilteredProducts($request);
        $categories = $this->categoryService->getActiveWithChildren();
        $brands = $this->brandService->getActive();
        $selectedCategory = $request->category ? $this->categoryService->with(['parent'])->find((int)$request->category) : null;
        $selectedBrand = $brands->find($request->brand);
        return view('client.products.show', compact('products', 'categories', 'brands', 'selectedCategory', 'selectedBrand'));
    }
    public function productDetailClient($id)
    {
        $product = $this->productService->with(['category'])->findOrFail($id);
        $seriesProducts = $this->productService->getProductsByCategory($product->category_id);
        $relatedProducts = $this->productService->getProductsByBrand($product->brand_id, $product->id, 6);
        $reviews = [
            [
                'user' => 'nice.Design',
                'time' => '26 thg 10, 2023',
                'stars' => 4,
                'title' => 'Dịch vụ của các bạn rất tốt',
                'comment' => "3 tốc độ hút tiện lợi, phù hợp với mọi loại bếp\nBộ lọc vách ngăn bằng thép không gỉ cao cấp có tác dụng loại bỏ dầu mỡ và các hạt bụi lớn từ không khí giúp bảo vệ động cơ, ngăn chặn tắc nghẽn, và giảm bụi bẩn và mỡ màng trên bề mặt trong không gian bếp, đảm bảo dễ dàng tháo lắp và vệ sinh hàng ngày",
                'likes' => 0,
                'replies' => [
                    [
                        'user' => 'nice.Design',
                        'time' => '26 thg 10, 2023',
                        'comment' => "3 tốc độ hút tiện lợi, phù hợp với mọi loại bếp\nBộ lọc vách ngăn bằng thép không gỉ cao cấp có tác dụng loại bỏ dầu mỡ và các hạt bụi lớn từ không khí giúp bảo vệ động cơ, ngăn chặn tắc nghẽn, và giảm bụi bẩn và mỡ màng trên bề mặt trong không gian bếp, đảm bảo dễ dàng tháo lắp và vệ sinh hàng ngày",
                    ]
                ]
            ],
            [
                'user' => 'nice.Design',
                'time' => '26 thg 10, 2023',
                'stars' => 4,
                'title' => 'Dịch vụ của các bạn rất tốt',
                'comment' => "3 tốc độ hút tiện lợi, phù hợp với mọi loại bếp\nBộ lọc vách ngăn bằng thép không gỉ cao cấp có tác dụng loại bỏ dầu mỡ và các hạt bụi lớn từ không khí giúp bảo vệ động cơ, ngăn chặn tắc nghẽn, và giảm bụi bẩn và mỡ màng trên bề mặt trong không gian bếp, đảm bảo dễ dàng tháo lắp và vệ sinh hàng ngày",
                'likes' => 0,
                'replies' => []
            ]
        ];
        return view('client.products.detail', compact('product', 'seriesProducts', 'relatedProducts', 'reviews'));
    }
}
