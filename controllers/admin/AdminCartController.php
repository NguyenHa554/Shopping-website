<?php
defined('SONNE_APP') or die('No direct access');

class AdminCartController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $status = $this->get('status');
        $search = $this->get('q');
        $total = CartModel::adminCount($status, $search);
        $pg = $this->paginate($total, ADMIN_ITEMS_PER_PAGE);
        $carts = CartModel::adminList($pg['offset'], $pg['limit'], $status, $search);

        $this->renderAdmin('carts/index', compact('carts', 'pg', 'status', 'search') + [
            'title' => 'Quản lý giỏ hàng',
        ]);
    }

    public function detail(array $p): void {
        Middleware::requireAdmin();
        $cart = CartModel::adminDetail((int)($p['id'] ?? 0));
        if (!$cart) {
            $this->redirectWith('/admin/carts', 'error', 'Không tìm thấy giỏ hàng.');
            return;
        }

        $this->renderAdmin('carts/detail', compact('cart') + [
            'title' => 'Chi tiết giỏ hàng',
        ]);
    }

    public function updateStatus(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();

        $userId = (int)($p['id'] ?? 0);
        $status = $_POST['status'] ?? 'active';
        $note = trim($_POST['note'] ?? '');
        $allowed = ['active', 'abandoned', 'contacted', 'archived'];
        if (!in_array($status, $allowed, true)) {
            $status = 'active';
        }

        CartModel::updateAdminStatus($userId, $status, $note !== '' ? $note : null);
        $this->redirectWith('/admin/carts/' . $userId, 'success', 'Cập nhật trạng thái giỏ hàng thành công.');
    }
}
