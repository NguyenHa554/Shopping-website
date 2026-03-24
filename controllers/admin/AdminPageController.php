<?php
defined('SONNE_APP') or die('No direct access');

class AdminPageController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $pages = PageContentModel::allAsMap();
        $this->renderAdmin('pages/index', compact('pages') + ['title' => 'Quản lý nội dung trang']);
    }
    public function update(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        foreach ($_POST['pages'] ?? [] as $key => $data) {
            $image = null;
            if (!empty($_FILES['page_images'][$key]['name'])) {
                $image = handleImageUpload($_FILES['page_images'][$key], 'pages');
            }
            PageContentModel::upsert(
                $key,
                $data['title'] ?? null,
                $data['content'] ?? null,
                $image
            );
        }
        $this->redirectWith('/admin/pages', 'success', 'Cập nhật nội dung thành công.');
    }
}
