<?php
defined('SONNE_APP') or die('No direct access');

class HomeController extends Controller {

    public function index(array $p): void {
        $categories  = CategoryModel::allWithCount();
        $featured    = ProductModel::featured(8);
        $flashSale   = ProductModel::flashSale(8);
        $newsLatest  = NewsModel::published(0, 3);
        $pageContent = PageContentModel::allAsMap();

        // Flash sale countdown target time
        $flashEndTime = null;
        if ($flashSale) {
            $flashEndTime = $flashSale[0]['flash_ends_at'];
        }

        $this->render('home/index', compact('categories', 'featured', 'flashSale', 'newsLatest', 'pageContent', 'flashEndTime'), 'main');
    }

    public function about(array $p): void {
        $pageContent = PageContentModel::allAsMap();
        $this->render('about/index', compact('pageContent'), 'main');
    }

    public function services(array $p): void {
        $pageContent = PageContentModel::allAsMap();
        $this->render('service/index', compact('pageContent') + ['title' => 'Dịch vụ - ' . APP_NAME], 'main');
    }

    public function pricing(array $p): void {
        $pageContent = PageContentModel::allAsMap();
        $this->render('pricing/index', compact('pageContent') + ['title' => 'Bảng giá - ' . APP_NAME], 'main');
    }

    public function seller(array $p): void {
        $pageContent = PageContentModel::allAsMap();
        $this->render('seller/index', compact('pageContent') + ['title' => 'Đăng ký gian hàng - ' . APP_NAME], 'main');
    }
}
