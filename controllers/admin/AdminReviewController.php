<?php
defined('SONNE_APP') or die('No direct access');

class AdminReviewController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $total   = ReviewModel::adminCount();
        $pg      = $this->paginate($total, ADMIN_ITEMS_PER_PAGE);
        $reviews = ReviewModel::adminList($pg['offset'], $pg['limit']);
        $this->renderAdmin('reviews/index', compact('reviews','pg') + ['title' => 'Quản lý đánh giá']);
    }
    public function delete(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        ReviewModel::softDelete((int)($p['id'] ?? 0));
        $this->redirectWith('/admin/reviews', 'success', 'Đã xoá đánh giá.');
    }
}
