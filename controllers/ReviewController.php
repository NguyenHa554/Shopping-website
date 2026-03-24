<?php
defined('SONNE_APP') or die('No direct access');

class ReviewController extends Controller {
    public function submit(array $p): void {
        Middleware::requireLogin();
        $this->validateCsrf();
        $pid     = (int)($_POST['product_id'] ?? 0);
        $rating  = max(1, min(5, (int)($_POST['rating'] ?? 5)));
        $comment = trim($_POST['comment'] ?? '');
        if (!$pid) { $this->redirect('/'); return; }

        ReviewModel::upsert($pid, (int)$this->currentUser()['id'], $rating, $comment);
        $product = DB::fetchOne("SELECT slug FROM products WHERE id=?", [$pid]);
        $slug = $product['slug'] ?? '';
        $this->redirectWith('/product/' . $slug, 'success', 'Đánh giá của bạn đã được lưu.');
    }
}
