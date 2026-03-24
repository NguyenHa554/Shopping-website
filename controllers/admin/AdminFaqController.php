<?php
defined('SONNE_APP') or die('No direct access');

class AdminFaqController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $faqs = FaqModel::allOrdered();
        $this->renderAdmin('faq/index', compact('faqs') + ['title' => 'Quản lý FAQ']);
    }
    public function create(array $p): void {
        Middleware::requireAdmin();
        $this->renderAdmin('faq/form', ['faq' => null, 'title' => 'Thêm FAQ']);
    }
    public function store(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        FaqModel::create([
            'question'   => trim($_POST['question'] ?? ''),
            'answer'     => trim($_POST['answer'] ?? ''),
            'sort_order' => (int)($_POST['sort_order'] ?? 0),
        ]);
        $this->redirectWith('/admin/faq', 'success', 'Thêm FAQ thành công.');
    }
    public function edit(array $p): void {
        Middleware::requireAdmin();
        $faq = FaqModel::find((int)($p['id'] ?? 0));
        if (!$faq) { $this->redirect('/admin/faq'); return; }
        $this->renderAdmin('faq/form', compact('faq') + ['title' => 'Sửa FAQ']);
    }
    public function update(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        FaqModel::update((int)($p['id'] ?? 0), [
            'question'   => trim($_POST['question'] ?? ''),
            'answer'     => trim($_POST['answer'] ?? ''),
            'sort_order' => (int)($_POST['sort_order'] ?? 0),
        ]);
        $this->redirectWith('/admin/faq', 'success', 'Cập nhật FAQ thành công.');
    }
    public function delete(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        FaqModel::delete((int)($p['id'] ?? 0));
        $this->redirectWith('/admin/faq', 'success', 'Đã xoá FAQ.');
    }
}
