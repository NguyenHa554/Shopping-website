<?php
defined('SONNE_APP') or die('No direct access');

class AdminCategoryController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $categories = CategoryModel::allWithCount();
        $this->renderAdmin('categories/index', compact('categories') + ['title' => 'Quản lý danh mục']);
    }
    public function store(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        $name = trim($_POST['name'] ?? '');
        $img  = null;
        if (!empty($_FILES['image']['name'])) $img = handleImageUpload($_FILES['image'], 'categories');
        CategoryModel::create(['name' => $name, 'slug' => slugify($name), 'image' => $img, 'sort_order' => (int)($_POST['sort_order'] ?? 0)]);
        $this->redirectWith('/admin/categories', 'success', 'Thêm danh mục thành công.');
    }
    public function update(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        $id  = (int)($p['id'] ?? 0);
        $cat = CategoryModel::find($id);
        $img = $cat['image'] ?? null;
        if (!empty($_FILES['image']['name'])) { if ($img) deleteUpload($img); $img = handleImageUpload($_FILES['image'], 'categories'); }
        CategoryModel::update($id, ['name' => trim($_POST['name'] ?? ''), 'image' => $img, 'sort_order' => (int)($_POST['sort_order'] ?? 0)]);
        $this->redirectWith('/admin/categories', 'success', 'Cập nhật danh mục thành công.');
    }
    public function delete(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        CategoryModel::delete((int)($p['id'] ?? 0));
        $this->redirectWith('/admin/categories', 'success', 'Đã xoá danh mục.');
    }
}
