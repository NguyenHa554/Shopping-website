<?php
defined('SONNE_APP') or die('No direct access');

class AdminOrderController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $status = $this->get('status');
        $total  = OrderModel::adminCount($status);
        $pg     = $this->paginate($total, ADMIN_ITEMS_PER_PAGE);
        $orders = OrderModel::adminList($pg['offset'], $pg['limit'], $status);
        $this->renderAdmin('orders/index', compact('orders', 'pg', 'status') + ['title' => 'Quản lý đơn hàng']);
    }
    public function detail(array $p): void {
        Middleware::requireAdmin();
        $order = OrderModel::getWithItems((int)($p['id'] ?? 0));
        if (!$order) { $this->redirect('/admin/orders'); return; }
        $this->renderAdmin('orders/detail', compact('order') + ['title' => 'Chi tiết đơn hàng #' . $order['id']]);
    }
    public function updateStatus(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        $allowed = ['pending','processing','shipped','delivered','cancelled'];
        $status  = in_array($_POST['status'] ?? '', $allowed) ? $_POST['status'] : 'pending';
        OrderModel::updateStatus((int)($p['id'] ?? 0), $status);
        $this->redirectWith('/admin/orders/' . ($p['id'] ?? ''), 'success', 'Cập nhật trạng thái thành công.');
    }
}
