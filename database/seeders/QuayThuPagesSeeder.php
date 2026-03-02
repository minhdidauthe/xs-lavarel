<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class QuayThuPagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            // ─── Quay Thử main pages ───
            [
                'slug' => 'quay-thu',
                'title' => 'Quay Thử Xổ Số Miền Bắc',
                'meta_title' => 'Quay Thử Xổ Số Miền Bắc - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số miền Bắc - Mô phỏng kết quả xổ số ngẫu nhiên miền Bắc hôm nay',
                'content' => 'Quay thử xổ số miền Bắc online miễn phí. Mô phỏng kết quả xổ số ngẫu nhiên với đầy đủ các giải từ giải Đặc Biệt đến giải 7.',
            ],
            [
                'slug' => 'quay-thu-mb',
                'title' => 'Quay Thử Xổ Số Miền Bắc',
                'meta_title' => 'Quay Thử Xổ Số Miền Bắc - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số miền Bắc - Mô phỏng kết quả xổ số ngẫu nhiên miền Bắc hôm nay',
                'content' => 'Quay thử xổ số miền Bắc online miễn phí. Mô phỏng kết quả xổ số ngẫu nhiên với đầy đủ các giải từ giải Đặc Biệt đến giải 7.',
            ],
            [
                'slug' => 'quay-thu-mn',
                'title' => 'Quay Thử Xổ Số Miền Nam',
                'meta_title' => 'Quay Thử Xổ Số Miền Nam - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số miền Nam - Mô phỏng kết quả xổ số ngẫu nhiên miền Nam hôm nay',
                'content' => 'Quay thử xổ số miền Nam online miễn phí. Mô phỏng kết quả xổ số ngẫu nhiên với đầy đủ các giải từ giải Đặc Biệt đến giải 8.',
            ],
            [
                'slug' => 'quay-thu-mt',
                'title' => 'Quay Thử Xổ Số Miền Trung',
                'meta_title' => 'Quay Thử Xổ Số Miền Trung - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số miền Trung - Mô phỏng kết quả xổ số ngẫu nhiên miền Trung hôm nay',
                'content' => 'Quay thử xổ số miền Trung online miễn phí. Mô phỏng kết quả xổ số ngẫu nhiên với đầy đủ các giải từ giải Đặc Biệt đến giải 8.',
            ],

            // ─── Miền Bắc provinces ───
            [
                'slug' => 'quay-thu-ha-noi',
                'title' => 'Quay Thử Xổ Số Hà Nội',
                'meta_title' => 'Quay Thử Xổ Số Hà Nội - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Hà Nội - Mô phỏng kết quả XSHN ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Hà Nội online miễn phí. Mô phỏng kết quả xổ số Hà Nội ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-bac-ninh',
                'title' => 'Quay Thử Xổ Số Bắc Ninh',
                'meta_title' => 'Quay Thử Xổ Số Bắc Ninh - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Bắc Ninh - Mô phỏng kết quả XSBN ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Bắc Ninh online miễn phí. Mô phỏng kết quả xổ số Bắc Ninh ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-thai-binh',
                'title' => 'Quay Thử Xổ Số Thái Bình',
                'meta_title' => 'Quay Thử Xổ Số Thái Bình - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Thái Bình - Mô phỏng kết quả XSTB ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Thái Bình online miễn phí. Mô phỏng kết quả xổ số Thái Bình ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-hai-phong',
                'title' => 'Quay Thử Xổ Số Hải Phòng',
                'meta_title' => 'Quay Thử Xổ Số Hải Phòng - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Hải Phòng - Mô phỏng kết quả XSHP ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Hải Phòng online miễn phí. Mô phỏng kết quả xổ số Hải Phòng ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-nam-dinh',
                'title' => 'Quay Thử Xổ Số Nam Định',
                'meta_title' => 'Quay Thử Xổ Số Nam Định - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Nam Định - Mô phỏng kết quả XSND ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Nam Định online miễn phí. Mô phỏng kết quả xổ số Nam Định ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-quang-ninh',
                'title' => 'Quay Thử Xổ Số Quảng Ninh',
                'meta_title' => 'Quay Thử Xổ Số Quảng Ninh - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Quảng Ninh - Mô phỏng kết quả XSQN ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Quảng Ninh online miễn phí. Mô phỏng kết quả xổ số Quảng Ninh ngẫu nhiên.',
            ],

            // ─── Miền Trung provinces ───
            [
                'slug' => 'quay-thu-hue',
                'title' => 'Quay Thử Xổ Số Huế',
                'meta_title' => 'Quay Thử Xổ Số Huế - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Huế - Mô phỏng kết quả XSTTH ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Huế online miễn phí. Mô phỏng kết quả xổ số Thừa Thiên Huế ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-khanh-hoa',
                'title' => 'Quay Thử Xổ Số Khánh Hòa',
                'meta_title' => 'Quay Thử Xổ Số Khánh Hòa - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Khánh Hòa - Mô phỏng kết quả XSKH ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Khánh Hòa online miễn phí. Mô phỏng kết quả xổ số Khánh Hòa ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-da-nang',
                'title' => 'Quay Thử Xổ Số Đà Nẵng',
                'meta_title' => 'Quay Thử Xổ Số Đà Nẵng - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Đà Nẵng - Mô phỏng kết quả XSDNG ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Đà Nẵng online miễn phí. Mô phỏng kết quả xổ số Đà Nẵng ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-binh-dinh',
                'title' => 'Quay Thử Xổ Số Bình Định',
                'meta_title' => 'Quay Thử Xổ Số Bình Định - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Bình Định - Mô phỏng kết quả XSBDI ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Bình Định online miễn phí. Mô phỏng kết quả xổ số Bình Định ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-quang-nam',
                'title' => 'Quay Thử Xổ Số Quảng Nam',
                'meta_title' => 'Quay Thử Xổ Số Quảng Nam - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Quảng Nam - Mô phỏng kết quả XSQNM ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Quảng Nam online miễn phí. Mô phỏng kết quả xổ số Quảng Nam ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-quang-ngai',
                'title' => 'Quay Thử Xổ Số Quảng Ngãi',
                'meta_title' => 'Quay Thử Xổ Số Quảng Ngãi - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Quảng Ngãi - Mô phỏng kết quả XSQNG ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Quảng Ngãi online miễn phí. Mô phỏng kết quả xổ số Quảng Ngãi ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-quang-tri',
                'title' => 'Quay Thử Xổ Số Quảng Trị',
                'meta_title' => 'Quay Thử Xổ Số Quảng Trị - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Quảng Trị - Mô phỏng kết quả XSQT ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Quảng Trị online miễn phí. Mô phỏng kết quả xổ số Quảng Trị ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-gia-lai',
                'title' => 'Quay Thử Xổ Số Gia Lai',
                'meta_title' => 'Quay Thử Xổ Số Gia Lai - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Gia Lai - Mô phỏng kết quả XSGL ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Gia Lai online miễn phí. Mô phỏng kết quả xổ số Gia Lai ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-ninh-thuan',
                'title' => 'Quay Thử Xổ Số Ninh Thuận',
                'meta_title' => 'Quay Thử Xổ Số Ninh Thuận - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Ninh Thuận - Mô phỏng kết quả XSNT ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Ninh Thuận online miễn phí. Mô phỏng kết quả xổ số Ninh Thuận ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-dak-lak',
                'title' => 'Quay Thử Xổ Số Đắk Lắk',
                'meta_title' => 'Quay Thử Xổ Số Đắk Lắk - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Đắk Lắk - Mô phỏng kết quả XSDLK ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Đắk Lắk online miễn phí. Mô phỏng kết quả xổ số Đắk Lắk ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-dak-nong',
                'title' => 'Quay Thử Xổ Số Đắk Nông',
                'meta_title' => 'Quay Thử Xổ Số Đắk Nông - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Đắk Nông - Mô phỏng kết quả XSDNO ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Đắk Nông online miễn phí. Mô phỏng kết quả xổ số Đắk Nông ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-phu-yen',
                'title' => 'Quay Thử Xổ Số Phú Yên',
                'meta_title' => 'Quay Thử Xổ Số Phú Yên - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Phú Yên - Mô phỏng kết quả XSPY ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Phú Yên online miễn phí. Mô phỏng kết quả xổ số Phú Yên ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-kon-tum',
                'title' => 'Quay Thử Xổ Số Kon Tum',
                'meta_title' => 'Quay Thử Xổ Số Kon Tum - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Kon Tum - Mô phỏng kết quả XSKT ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Kon Tum online miễn phí. Mô phỏng kết quả xổ số Kon Tum ngẫu nhiên.',
            ],

            // ─── Miền Nam provinces ───
            [
                'slug' => 'quay-thu-ho-chi-minh',
                'title' => 'Quay Thử Xổ Số TP Hồ Chí Minh',
                'meta_title' => 'Quay Thử Xổ Số TP HCM - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số TP Hồ Chí Minh - Mô phỏng kết quả XSHCM ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số TP Hồ Chí Minh online miễn phí. Mô phỏng kết quả xổ số HCM ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-dong-nai',
                'title' => 'Quay Thử Xổ Số Đồng Nai',
                'meta_title' => 'Quay Thử Xổ Số Đồng Nai - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Đồng Nai - Mô phỏng kết quả XSDN ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Đồng Nai online miễn phí. Mô phỏng kết quả xổ số Đồng Nai ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-can-tho',
                'title' => 'Quay Thử Xổ Số Cần Thơ',
                'meta_title' => 'Quay Thử Xổ Số Cần Thơ - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Cần Thơ - Mô phỏng kết quả XSCT ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Cần Thơ online miễn phí. Mô phỏng kết quả xổ số Cần Thơ ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-dong-thap',
                'title' => 'Quay Thử Xổ Số Đồng Tháp',
                'meta_title' => 'Quay Thử Xổ Số Đồng Tháp - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Đồng Tháp - Mô phỏng kết quả XSDT ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Đồng Tháp online miễn phí. Mô phỏng kết quả xổ số Đồng Tháp ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-ca-mau',
                'title' => 'Quay Thử Xổ Số Cà Mau',
                'meta_title' => 'Quay Thử Xổ Số Cà Mau - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Cà Mau - Mô phỏng kết quả XSCM ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Cà Mau online miễn phí. Mô phỏng kết quả xổ số Cà Mau ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-ben-tre',
                'title' => 'Quay Thử Xổ Số Bến Tre',
                'meta_title' => 'Quay Thử Xổ Số Bến Tre - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Bến Tre - Mô phỏng kết quả XSBT ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Bến Tre online miễn phí. Mô phỏng kết quả xổ số Bến Tre ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-vung-tau',
                'title' => 'Quay Thử Xổ Số Vũng Tàu',
                'meta_title' => 'Quay Thử Xổ Số Vũng Tàu - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Vũng Tàu - Mô phỏng kết quả XSVT ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Vũng Tàu online miễn phí. Mô phỏng kết quả xổ số Vũng Tàu ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-bac-lieu',
                'title' => 'Quay Thử Xổ Số Bạc Liêu',
                'meta_title' => 'Quay Thử Xổ Số Bạc Liêu - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Bạc Liêu - Mô phỏng kết quả XSBL ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Bạc Liêu online miễn phí. Mô phỏng kết quả xổ số Bạc Liêu ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-soc-trang',
                'title' => 'Quay Thử Xổ Số Sóc Trăng',
                'meta_title' => 'Quay Thử Xổ Số Sóc Trăng - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Sóc Trăng - Mô phỏng kết quả XSST ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Sóc Trăng online miễn phí. Mô phỏng kết quả xổ số Sóc Trăng ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-an-giang',
                'title' => 'Quay Thử Xổ Số An Giang',
                'meta_title' => 'Quay Thử Xổ Số An Giang - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số An Giang - Mô phỏng kết quả XSAG ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số An Giang online miễn phí. Mô phỏng kết quả xổ số An Giang ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-binh-thuan',
                'title' => 'Quay Thử Xổ Số Bình Thuận',
                'meta_title' => 'Quay Thử Xổ Số Bình Thuận - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Bình Thuận - Mô phỏng kết quả XSBTH ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Bình Thuận online miễn phí. Mô phỏng kết quả xổ số Bình Thuận ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-vinh-long',
                'title' => 'Quay Thử Xổ Số Vĩnh Long',
                'meta_title' => 'Quay Thử Xổ Số Vĩnh Long - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Vĩnh Long - Mô phỏng kết quả XSVL ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Vĩnh Long online miễn phí. Mô phỏng kết quả xổ số Vĩnh Long ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-binh-duong',
                'title' => 'Quay Thử Xổ Số Bình Dương',
                'meta_title' => 'Quay Thử Xổ Số Bình Dương - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Bình Dương - Mô phỏng kết quả XSBD ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Bình Dương online miễn phí. Mô phỏng kết quả xổ số Bình Dương ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-tra-vinh',
                'title' => 'Quay Thử Xổ Số Trà Vinh',
                'meta_title' => 'Quay Thử Xổ Số Trà Vinh - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Trà Vinh - Mô phỏng kết quả XSTV ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Trà Vinh online miễn phí. Mô phỏng kết quả xổ số Trà Vinh ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-long-an',
                'title' => 'Quay Thử Xổ Số Long An',
                'meta_title' => 'Quay Thử Xổ Số Long An - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Long An - Mô phỏng kết quả XSLA ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Long An online miễn phí. Mô phỏng kết quả xổ số Long An ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-binh-phuoc',
                'title' => 'Quay Thử Xổ Số Bình Phước',
                'meta_title' => 'Quay Thử Xổ Số Bình Phước - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Bình Phước - Mô phỏng kết quả XSBP ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Bình Phước online miễn phí. Mô phỏng kết quả xổ số Bình Phước ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-hau-giang',
                'title' => 'Quay Thử Xổ Số Hậu Giang',
                'meta_title' => 'Quay Thử Xổ Số Hậu Giang - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Hậu Giang - Mô phỏng kết quả XSHG ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Hậu Giang online miễn phí. Mô phỏng kết quả xổ số Hậu Giang ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-tien-giang',
                'title' => 'Quay Thử Xổ Số Tiền Giang',
                'meta_title' => 'Quay Thử Xổ Số Tiền Giang - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Tiền Giang - Mô phỏng kết quả XSTG ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Tiền Giang online miễn phí. Mô phỏng kết quả xổ số Tiền Giang ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-kien-giang',
                'title' => 'Quay Thử Xổ Số Kiên Giang',
                'meta_title' => 'Quay Thử Xổ Số Kiên Giang - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Kiên Giang - Mô phỏng kết quả XSKG ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Kiên Giang online miễn phí. Mô phỏng kết quả xổ số Kiên Giang ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-tay-ninh',
                'title' => 'Quay Thử Xổ Số Tây Ninh',
                'meta_title' => 'Quay Thử Xổ Số Tây Ninh - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Tây Ninh - Mô phỏng kết quả XSTN ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Tây Ninh online miễn phí. Mô phỏng kết quả xổ số Tây Ninh ngẫu nhiên.',
            ],
            [
                'slug' => 'quay-thu-lam-dong',
                'title' => 'Quay Thử Xổ Số Lâm Đồng',
                'meta_title' => 'Quay Thử Xổ Số Lâm Đồng - SOICAU7777.CLICK',
                'meta_description' => 'Quay thử xổ số Lâm Đồng - Mô phỏng kết quả XSLD ngẫu nhiên hôm nay',
                'content' => 'Quay thử xổ số Lâm Đồng online miễn phí. Mô phỏng kết quả xổ số Lâm Đồng ngẫu nhiên.',
            ],

            // ─── Soi Cầu ───
            [
                'slug' => 'soi-cau',
                'title' => 'Soi Cầu Xổ Số',
                'meta_title' => 'Soi Cầu Xổ Số - Dự Đoán KQXS Chính Xác - SOICAU7777.CLICK',
                'meta_description' => 'Soi cầu xổ số 3 miền chính xác nhất. Dự đoán KQXS miền Bắc, miền Trung, miền Nam hôm nay bằng AI.',
                'content' => 'Soi cầu xổ số 3 miền chính xác nhất. Sử dụng thuật toán AI phân tích dữ liệu lịch sử để đưa ra dự đoán kết quả xổ số hôm nay.',
            ],
        ];

        $count = 0;
        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                [
                    'author_id' => 1,
                    'title' => $pageData['title'],
                    'content' => $pageData['content'],
                    'rendered_content' => null,
                    'meta_title' => $pageData['meta_title'],
                    'meta_description' => $pageData['meta_description'],
                    'template' => null,
                    'status' => 'published',
                    'sort_order' => 0,
                ]
            );
            $count++;
        }

        $this->command->info("QuayThuPagesSeeder: {$count} pages seeded successfully.");
    }
}
