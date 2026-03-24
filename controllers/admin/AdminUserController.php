<?php
defined('SONNE_APP') or die('No direct access');

class AdminUserController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $search = $this->get('q');
        $total  = UserModel::countAll($search);
        $pg     = $this->paginate($total, ADMIN_ITEMS_PER_PAGE);
        $users  = UserModel::paginate($pg['offset'], $pg['limit'], $search);
        $this->renderAdmin('users/index', compact('users', 'pg', 'search') + ['title' => 'Quản lý thành viên']);
    }
    public function edit(array $p): void {
        Middleware::requireAdmin();
        $user = UserModel::find((int)($p['id'] ?? 0));
        if (!$user) { $this->redirect('/admin/users'); return; }
        $this->renderAdmin('users/edit', compact('user') + ['title' => 'Sửa thành viên']);
    }
    public function update(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        $id = (int)($p['id'] ?? 0);
        UserModel::update($id, [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? ''),
            'address'   => trim($_POST['address'] ?? ''),
            'role'      => in_array($_POST['role'] ?? '', ['member','admin']) ? $_POST['role'] : 'member',
        ]);
        $this->redirectWith('/admin/users', 'success', 'Cập nhật thành viên thành công.');
    }
    public function toggleLock(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        UserModel::toggleLock((int)($p['id'] ?? 0));
        $this->redirectWith('/admin/users', 'success', 'Đã thay đổi trạng thái tài khoản.');
    }
    public function delete(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        UserModel::softDelete((int)($p['id'] ?? 0));
        $this->redirectWith('/admin/users', 'success', 'Đã xoá thành viên.');
    }
    public function resetPassword(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        $id   = (int)($p['id'] ?? 0);
        $hash = password_hash('Sonne@123', PASSWORD_BCRYPT);
        UserModel::updatePassword($id, $hash);
        $this->redirectWith('/admin/users', 'success', 'Đặt lại mật khẩu thành Sonne@123.');
    }
}
