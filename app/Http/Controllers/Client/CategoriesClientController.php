<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class CategoriesClientController extends Controller
{
    public function showClient()
    {
        $categories = [
            [
                'name' => 'Cảm biến',
                'children' => [
                    'Cảm biến tiệm cận',
                    'Cảm biến quang',
                    'Cảm biến sợi quang',
                    'Cảm biến cửa',
                    'Cảm biến vùng',
                    'Cảm biến hình ảnh',
                    'Cảm biến áp suất',
                    'Cảm biến đo lường',
                    'Bộ mã vòng quay/ Encoder',
                    'Phụ kiện cảm biến',
                    'Bộ điều khiển cảm biến',
                ]
            ],
            [
                'name' => 'Bộ đổi nguồn DC',
                'children' => [
                    'Bộ nguồn DC Adapter',
                    'Bộ nguồn DC có điều chỉnh',
                ]
            ],
            [
                'name' => 'Biến áp',
                'children' => [
                    'Biến áp cách ly',
                    'Biến áp tự ngẫu',
                    'Phụ kiện hiển thị',
                ]
            ],
            [
                'name' => 'Biến tần',
                'children' => [
                    'Biến tần hạ thế',
                    'Biến tần trung thế',
                ]
            ],
            [
                'name' => 'Driver/ Motor Servo',
                'children' => [
                    'Driver Servo',
                    'Motor Servo',
                    'Cáp Servo',
                ]
            ],
            [
                'name' => 'PLC/ HMI',
                'children' => [
                    'PLC',
                    'HMI',
                    'Zen',
                    'Logo',
                ]
            ],
            [
                'name' => 'Relay',
                'children' => [
                    'Relay trung gian',
                    'Relay trung gian bán dẫn',
                    'Relay bán dẫn',
                    'Relay luân phiên',
                    'Relay an toàn',
                    'Relay Terminal',
                    'I/O Relay Terminal',
                ]
            ],
            [
                'name' => 'Chuyển mạch/ Nút bấm',
                'children' => [
                    'Chuyển mạch 2 - 3 vị trí',
                    'Chuyển mạch có khóa',
                    'Cần gạt 2 - 4 hướng',
                    'Chuyển mạch khác',
                    'Nút nhấn',
                    'Đèn báo',
                    'Đèn báo panel tròn',
                    'Đèn báo panel khối',
                    'Đèn báo tháp',
                    'Đèn báo quay',
                    'Đèn báo khác',
                ]
            ],
            [
                'name' => 'Phích cắm/ Ổ cắm công nghiệp',
                'children' => [
                    'Ổ cắm công nghiệp',
                    'Phích cắm công nghiệp',
                ]
            ],
            [
                'name' => 'Công tắc ổ cắm dân dụng',
                'children' => [
                    'Phụ kiện mặt công tắc ổ cắm',
                    'Phụ kiện đế công tắc ổ cắm',
                    'Phụ kiện công tắc',
                    'Dòng công tắc theo bộ',
                    'Dòng ổ cắm theo bộ',
                ]
            ],
            [
                'name' => 'Phụ kiện tủ điện',
                'children' => [
                    'Cầu đấu khối',
                    'Cầu đấu ghép gắn Din Ray',
                    'Din Ray',
                    'Điện trở sấy tủ điện',
                    'Quạt thông gió tủ điện',
                    'Điều hòa tủ điện',
                    'Máng nhựa',
                ]
            ],
            [
                'name' => 'Logic relay',
                'children' => [
                    'Zelio',
                ]
            ],
            [
                'name' => 'Đồng hồ đo',
                'children' => [
                    'Đồng hồ Counter',
                    'Đồng hồ Timer',
                    'Đồng hồ Counter/ Timer',
                    'Đồng hồ nhiệt độ',
                    'Đồng hồ đo xung/ tốc độ',
                    'Đồng hồ đo hiển thị số',
                    'Đồng hồ đo giám sát điện năng',
                ]
            ],
            [
                'name' => 'Cáp / Giắc kết nối',
                'children' => [
                    'Cáp lập trình PLC/ HMI',
                    'Cáp CC-Link',
                    'Cáp mạng',
                    'Cáp điều khiển Servo',
                    'Cáp I/O',
                    'Giắc kết nối',
                ]
            ],
            [
                'name' => 'Bộ chuyển tín hiệu',
                'children' => [
                    'Bộ chuyển đổi Analog',
                    'Bộ chuyển đổi truyền thống',
                    'Bộ điều khiển Thyristor',
                ]
            ],
            [
                'name' => 'Thiết bị đóng cắt',
                'children' => [
                    'Vỏ cầu chì - Ruột cầu chì',
                    'MCB cầu dao tự động - dạng cài',
                    'RCCB Cầu dao chống dòng rò - dạng cài',
                    'RCBO Cầu dao tích hợp chống dòng rò - dạng cài',
                    'Cầu dao chống sét - dạng cài',
                    'MCCB Cầu dao tự động - dạng khối',
                    'MCCB Cầu dao tự động - dạng khối (loại chỉnh dòng)',
                    'ELCB Cầu dao chống dòng rò - dạng khối',
                    'MotorCB Cầu dao bảo vệ motor - dạng khối',
                    'Khởi động mềm',
                    'ACB Máy cắt không khí',
                    'ATS Compact (MCCB/CB)',
                    'ATS Masterpact (ACB)',
                    'Contactor',
                    'Relay nhiệt',
                    'Khởi động mềm 1 pha',
                    'Khởi động mềm 3 pha',
                ]
            ],
            [
                'name' => 'Công tắc hành trình - Safety',
                'children' => [
                    'Công tắc hành trình',
                    'Công tắc hành trình và Safety',
                    'Công tắc cửa Safety',
                    'Khóa - Công tắc cửa Safety',
                ]
            ],
            [
                'name' => 'Thiết bị bán dẫn',
                'children' => [
                    'Contactor bán dẫn',
                ]
            ],
            [
                'name' => 'Bảo vệ pha/ Động cơ',
                'children' => [
                    'Bộ bảo vệ pha',
                    'Bộ bảo vệ động cơ 3P',
                ]
            ],
            [
                'name' => 'Bộ điều khiển mức chất lỏng',
                'children' => [
                    'Bộ điều khiển mức chất lỏng',
                ]
            ],
            [
                'name' => 'Thiết bị đo lường',
                'children' => [
                    'Biến dòng',
                    'Đồng hồ Vol-Ampe',
                    'Chuyển mạch Vol-Ampe',
                    'Công tơ',
                    'Bộ điều khiển tụ bù',
                    'Đồng hồ đo hệ số công suất',
                ]
            ]
        ];

        return view('client.categogies.show', compact('categories'));
    }
    public function detailClient($id)
    {
        $sampleProducts = [
            [
                'brand' => 'Schneider Electric',
                'name' => 'Cầu dao tự động dạng cài SIEMENS NS080N3M2',
                'price' => '18.187.450',
                'old_price' => '20.187.450',
                'discount' => '-23%',
                'stars' => 4,
                'reviews' => 227,
            ],
            [
                'brand' => 'Siemens',
                'name' => 'Bộ lập trình PLC S7-1200 CPU 1214C DC/DC/DC công suất cao bền bỉ cho doanh nghiệp',
                'price' => '5.620.000',
                'old_price' => '6.800.000',
                'discount' => '-17%',
                'stars' => 5,
                'reviews' => 94,
            ],
            [
                'brand' => 'Omron',
                'name' => 'Cảm biến tiệm cận E2E-X5ME1 2M OMRON chính hãng',
                'price' => '1.250.000',
                'old_price' => '',
                'discount' => '',
                'stars' => 4,
                'reviews' => 112,
            ],
            [
                'brand' => 'Schneider Electric',
                'name' => 'Cầu dao tự động dạng cài SIEMENS NS080N3M2',
                'price' => '18.187.450',
                'old_price' => '20.187.450',
                'discount' => '-23%',
                'stars' => 4,
                'reviews' => 227,
            ],
            [
                'brand' => 'Siemens',
                'name' => 'Bộ lập trình PLC S7-1200 CPU 1214C DC/DC/DC công suất cao bền bỉ cho doanh nghiệp',
                'price' => '5.620.000',
                'old_price' => '6.800.000',
                'discount' => '-17%',
                'stars' => 5,
                'reviews' => 94,
            ],
            [
                'brand' => 'Omron',
                'name' => 'Cảm biến tiệm cận E2E-X5ME1 2M OMRON chính hãng',
                'price' => '1.250.000',
                'old_price' => '',
                'discount' => '',
                'stars' => 4,
                'reviews' => 112,
            ],
            [
                'brand' => 'Schneider Electric',
                'name' => 'Cầu dao tự động dạng cài SIEMENS NS080N3M2',
                'price' => '18.187.450',
                'old_price' => '20.187.450',
                'discount' => '-23%',
                'stars' => 4,
                'reviews' => 227,
            ],
            [
                'brand' => 'Siemens',
                'name' => 'Bộ lập trình PLC S7-1200 CPU 1214C DC/DC/DC công suất cao bền bỉ cho doanh nghiệp',
                'price' => '5.620.000',
                'old_price' => '6.800.000',
                'discount' => '-17%',
                'stars' => 5,
                'reviews' => 94,
            ],
            [
                'brand' => 'Omron',
                'name' => 'Cảm biến tiệm cận E2E-X5ME1 2M OMRON chính hãng',
                'price' => '1.250.000',
                'old_price' => '',
                'discount' => '',
                'stars' => 4,
                'reviews' => 112,
            ],
        ];

        return view('client.categogies.detail', compact('sampleProducts'));
    }
}
