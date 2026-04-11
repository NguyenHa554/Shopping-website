<?php
defined('SONNE_APP') or die('No direct access');

class AdminNewsCommentController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $search   = $this->get('q');
        $total    = NewsModel::adminCommentCount($search);
        $pg       = $this->paginate($total, ADMIN_ITEMS_PER_PAGE);
        $comments = NewsModel::adminComments($pg['offset'], $pg['limit'], $search);
        $this->renderAdmin('news_comments/index', compact('comments', 'pg', 'search') + ['title' => 'Bình luận tin tức']);
    }

    public function delete(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        NewsModel::deleteComment((int)($p['id'] ?? 0));
        $this->redirectWith('/admin/news-comments', 'success', 'Đã xóa bình luận.');
    }
}
