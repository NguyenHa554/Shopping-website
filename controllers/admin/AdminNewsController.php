<?php
defined('SONNE_APP') or die('No direct access');

class AdminNewsController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $search = $this->get('q');
        $total  = NewsModel::adminCount($search);
        $pg     = $this->paginate($total, ADMIN_ITEMS_PER_PAGE);
        $articles = NewsModel::adminList($pg['offset'], $pg['limit'], $search);
        $this->renderAdmin('news/index', compact('articles', 'pg', 'search') + ['title' => 'Quản lý tin tức']);
    }
    public function create(array $p): void {
        Middleware::requireAdmin();
        $this->renderAdmin('news/form', ['article' => null, 'title' => 'Thêm bài viết']);
    }
    public function store(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        $title   = trim($_POST['title'] ?? '');
        $body    = trim($_POST['body'] ?? '');
        $status  = in_array($_POST['status'] ?? 'published', ['draft', 'published'], true)
            ? $_POST['status']
            : 'published';

        if (mb_strlen($title) < 5 || $body === '') {
            $this->redirectWith('/admin/news/create', 'error', 'Tiêu đề tối thiểu 5 ký tự và nội dung không được để trống.');
            return;
        }

        $slug    = slugify($title) . '-' . time();
        $cover   = null;
        if (!empty($_FILES['cover_image']['name'])) $cover = handleImageUpload($_FILES['cover_image'], 'news');
        NewsModel::create([
            'author_id'        => (int)$this->currentUser()['id'],
            'title'            => $title,
            'slug'             => $slug,
            'summary'          => $_POST['summary'] ?? null,
            'body'             => $body,
            'cover_image'      => $cover,
            'meta_title'       => $_POST['meta_title'] ?? $title,
            'meta_description' => $_POST['meta_description'] ?? null,
            'meta_keywords'    => $_POST['meta_keywords'] ?? null,
            'status'           => $status,
            'published_at'     => date('Y-m-d H:i:s'),
        ]);
        $this->redirectWith('/admin/news', 'success', 'Thêm bài viết thành công.');
    }
    public function edit(array $p): void {
        Middleware::requireAdmin();
        $article = NewsModel::find((int)($p['id'] ?? 0));
        if (!$article) { $this->redirect('/admin/news'); return; }
        $this->renderAdmin('news/form', compact('article') + ['title' => 'Sửa bài viết']);
    }
    public function update(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        $id      = (int)($p['id'] ?? 0);
        $article = NewsModel::find($id);
        if (!$article) { $this->redirect('/admin/news'); return; }
        $title   = trim($_POST['title'] ?? '');
        $body    = trim($_POST['body'] ?? '');
        $status  = in_array($_POST['status'] ?? 'published', ['draft', 'published'], true)
            ? $_POST['status']
            : 'published';

        if (mb_strlen($title) < 5 || $body === '') {
            $this->redirectWith('/admin/news/edit/' . $id, 'error', 'Tiêu đề tối thiểu 5 ký tự và nội dung không được để trống.');
            return;
        }

        $cover = $article['cover_image'];
        if (!empty($_FILES['cover_image']['name'])) {
            if ($cover) deleteUpload($cover);
            $cover = handleImageUpload($_FILES['cover_image'], 'news');
        }
        NewsModel::update($id, [
            'title'            => $title,
            'summary'          => $_POST['summary'] ?? null,
            'body'             => $body,
            'cover_image'      => $cover,
            'meta_title'       => $_POST['meta_title'] ?? null,
            'meta_description' => $_POST['meta_description'] ?? null,
            'meta_keywords'    => $_POST['meta_keywords'] ?? null,
            'status'           => $status,
        ]);
        $this->redirectWith('/admin/news', 'success', 'Cập nhật bài viết thành công.');
    }
    public function delete(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        NewsModel::softDelete((int)($p['id'] ?? 0));
        $this->redirectWith('/admin/news', 'success', 'Đã xoá bài viết.');
    }
}
