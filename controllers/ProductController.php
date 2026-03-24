<?php
defined('SONNE_APP') or die('No direct access');

class ProductController extends Controller {

    public function index(array $p): void {
        $categories = CategoryModel::allWithCount();
        $total = ProductModel::adminCount();
        $pg = $this->paginate($total);

        $products = DB::fetchAll(
            "SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id=c.id
             WHERE p.status='active' AND p.deleted_at IS NULL ORDER BY p.id DESC LIMIT ? OFFSET ?",
            [$pg['limit'], $pg['offset']]
        );
        $this->render('product/search', compact('products', 'categories', 'pg') + [
            'title'   => 'Tất cả sản phẩm – ' . APP_NAME,
            'keyword' => '',
            'empty'   => empty($products),
        ], 'main');
    }

    public function detail(array $p): void {
        $product = ProductModel::findBySlug($p['slug'] ?? '');
        if (!$product) { http_response_code(404); $this->render('errors/404', []); return; }

        $images    = ProductModel::getImages((int)$product['id']);
        $reviews   = ReviewModel::forProduct((int)$product['id']);
        $avgRating = ReviewModel::averageRating((int)$product['id']);
        $related   = ProductModel::related((int)$product['category_id'], (int)$product['id']);
        $userReview = null;
        if ($this->isLoggedIn()) {
            foreach ($reviews as $r) {
                if ((int)$r['user_id'] === (int)$this->currentUser()['id']) { $userReview = $r; break; }
            }
        }

        $this->render('product/detail', compact('product','images','reviews','avgRating','related','userReview') + [
            'title' => e($product['name']) . ' – ' . APP_NAME,
        ], 'main');
    }

    public function search(array $p): void {
        $keyword    = $this->get('q');
        $sort       = $this->get('sort', 'newest');
        $catSlug    = $this->get('cat');
        $categories = CategoryModel::allWithCount();

        if ($keyword) {
            $total    = ProductModel::countSearch($keyword);
            $pg       = $this->paginate($total);
            $products = ProductModel::search($keyword, $pg['offset'], $pg['limit'], $sort);
        } else {
            $total    = 0;
            $pg       = $this->paginate(0);
            $products = [];
        }

        $this->render('product/search', compact('products', 'categories', 'pg', 'keyword', 'sort') + [
            'title' => "Tìm kiếm: " . e($keyword) . " – " . APP_NAME,
            'empty' => empty($products),
        ], 'main');
    }

    public function category(array $p): void {
        $cat = CategoryModel::findBySlug($p['slug'] ?? '');
        if (!$cat) { http_response_code(404); $this->render('errors/404', []); return; }

        $categories = CategoryModel::allWithCount();
        $total    = ProductModel::countByCategory((int)$cat['id']);
        $pg       = $this->paginate($total);
        $products = ProductModel::byCategory((int)$cat['id'], $pg['offset'], $pg['limit']);

        $this->render('product/search', compact('products', 'categories', 'pg', 'cat') + [
            'title'   => e($cat['name']) . ' – ' . APP_NAME,
            'keyword' => '',
            'empty'   => empty($products),
        ], 'main');
    }
}
