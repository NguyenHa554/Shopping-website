<?php
defined('SONNE_APP') or die('No direct access');

class NewsController extends Controller {

    public function index(array $p): void {
        $keyword = $this->get('q');
        $total   = NewsModel::countPublished($keyword);
        $pg      = $this->paginate($total, 9);
        $articles = NewsModel::published($pg['offset'], $pg['limit'], $keyword);

        $this->render('news/list', compact('articles', 'pg', 'keyword') + [
            'title' => 'Tin tức – ' . APP_NAME,
            'empty' => empty($articles),
        ], 'main');
    }

    public function detail(array $p): void {
        $article = NewsModel::findBySlug($p['slug'] ?? '');
        if (!$article) { http_response_code(404); $this->render('errors/404', []); return; }

        $comments = NewsModel::getComments((int)$article['id']);
        $recent   = NewsModel::published(0, 4);

        $this->render('news/detail', compact('article', 'comments', 'recent') + [
            'title' => e($article['title']) . ' – ' . APP_NAME,
        ], 'main');
    }

    public function postComment(array $p): void {
        Middleware::requireLogin();
        $this->validateCsrf();
        $newsId  = (int)($p['id'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');
        if (!$comment || !$newsId) { $this->redirect('/news'); return; }
        NewsModel::addComment($newsId, (int)$this->currentUser()['id'], $comment);
        $this->redirectWith('/news/' . $p['id'], 'success', 'Bình luận đã được gửi.');
    }
}
