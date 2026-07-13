<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class ProductClientController extends Controller
{
    public function productDetailClient($id)
    {
        $product = [
            'id' => $id,
            'name' => 'Motor circuit breaker,TeSys Deca frame 3,3P,30-40A',
            'sku' => 'GV3P40',
            'price' => '1.890.000',
            'oldPrice' => '2.500.000',
            'reviewsCount' => 5,
            'images' => [
                'storage/images/chitiet1.jpg',
                'storage/images/chitiet1.jpg',
                'storage/images/chitiet1.jpg',
                'storage/images/chitiet1.jpg',
                'storage/images/chitiet1.jpg',
            ],
        ];

        $seriesProducts = [
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4,
                'power' => '0.75kW',
                'oldPrice' => '150.000',
                'price' => '99.000',
                'status' => 'Còn hàng',
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 3,
                'power' => '0.75kW',
                'oldPrice' => '150.000',
                'price' => '99.000',
                'status' => 'Đặt hàng',
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4,
                'power' => '0.75kW',
                'oldPrice' => '150.000',
                'price' => '99.000',
                'status' => 'Còn hàng',
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4,
                'power' => '0.75kW',
                'oldPrice' => '150.000',
                'price' => '99.000',
                'status' => 'Còn hàng',
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4,
                'power' => '0.75kW',
                'oldPrice' => '150.000',
                'price' => '99.000',
                'status' => 'Còn hàng',
                'image' => 'storage/images/chitiet1.jpg',
            ],
        ];

        $relatedProducts = [
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4.5,
                'power' => '0.75kW',
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4.5,
                'power' => '0.75kW',
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4.5,
                'power' => '0.75kW',
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4.5,
                'power' => '0.75kW',
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4.5,
                'power' => '0.75kW',
                'image' => 'storage/images/chitiet1.jpg',
            ],
            [
                'sku' => 'ATV212H075M3X',
                'stars' => 4.5,
                'power' => '0.75kW',
                'image' => 'storage/images/chitiet1.jpg',
            ],
        ];

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
