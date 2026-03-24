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
}
