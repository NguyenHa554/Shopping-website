<?php
defined('SONNE_APP') or die('No direct access');

class AdminContactController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $status = $this->get('status');
        $total  = ContactModel::adminCount($status);
        $pg     = $this->paginate($total, ADMIN_ITEMS_PER_PAGE);
        $contacts = ContactModel::adminList($pg['offset'], $pg['limit'], $status);
        $this->renderAdmin('contacts/index', compact('contacts','pg','status') + ['title' => 'Quản lý liên hệ']);
    }
    public function view(array $p): void {
        Middleware::requireAdmin();
        $contact = ContactModel::find((int)($p['id'] ?? 0));
        if (!$contact) { $this->redirect('/admin/contacts'); return; }
        if ($contact['status'] === 'unread') ContactModel::updateStatus((int)$contact['id'], 'read');
        $this->renderAdmin('contacts/view', compact('contact') + ['title' => 'Chi tiết liên hệ']);
    }
    public function updateStatus(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        $allowed = ['unread','read','replied'];
        $status  = in_array($_POST['status'] ?? '', $allowed) ? $_POST['status'] : 'read';
        ContactModel::updateStatus((int)($p['id'] ?? 0), $status);
        $this->redirectWith('/admin/contacts/' . ($p['id'] ?? ''), 'success', 'Cập nhật trạng thái.');
    }
    public function delete(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        ContactModel::delete((int)($p['id'] ?? 0));
        $this->redirectWith('/admin/contacts', 'success', 'Đã xoá liên hệ.');
    }
}
