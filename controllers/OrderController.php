<?php
defined('SONNE_APP') or die('No direct access');

class OrderController extends Controller {

    public function checkoutForm(array $p): void {
        Middleware::requireLogin();
        $userId = (int)$this->currentUser()['id'];
        $items  = CartModel::getItems($userId);
        if (empty($items)) { $this->redirect('/cart'); return; }

        $subtotal = array_sum(array_map(fn($i) => (float)($i['sale_price'] ?? $i['price']) * $i['quantity'], $items));
        $shipping = $subtotal >= 500000 ? 0 : 30000;

        $this->render('checkout/index', compact('items', 'subtotal', 'shipping') + [
            'title' => 'Thanh toán – ' . APP_NAME,
            'user'  => $this->currentUser(),
        ], 'main');
    }

    public function placeOrder(array $p): void {
        Middleware::requireLogin();
        $this->validateCsrf();
        $userId = (int)$this->currentUser()['id'];
        $items  = CartModel::getItems($userId);

        if (empty($items)) { $this->redirect('/cart'); return; }

        // Validate form
        $fullName = trim($_POST['full_name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $address  = trim($_POST['address'] ?? '');
        $note     = trim($_POST['note'] ?? '');
        $payment  = in_array($_POST['payment_method'] ?? '', ['cod','bank_transfer','credit_card'])
                        ? $_POST['payment_method'] : 'cod';

        if (!$fullName || !$email || !$phone || !$address) {
            $this->redirectWith('/checkout', 'error', 'Vui lòng điền đầy đủ thông tin.');
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirectWith('/checkout', 'error', 'Email không hợp lệ.');
            return;
        }
        if (!preg_match('/^\d{9,12}$/', $phone)) {
            $this->redirectWith('/checkout', 'error', 'Số điện thoại không hợp lệ.');
            return;
        }

        $subtotal = array_sum(array_map(fn($i) => (float)($i['sale_price'] ?? $i['price']) * $i['quantity'], $items));
        $shipping = $subtotal >= 500000 ? 0 : 30000;
        $total    = $subtotal + $shipping;

        $orderItems = array_map(fn($i) => [
            'product_id'  => $i['product_id'],
            'name'        => $i['name'],
            'cover_image' => $i['cover_image'],
            'unit_price'  => (float)($i['sale_price'] ?? $i['price']),
            'quantity'    => (int)$i['quantity'],
        ], $items);

        try {
            $orderId = OrderModel::createOrder([
                'user_id'        => $userId,
                'full_name'      => $fullName,
                'email'          => $email,
                'phone'          => $phone,
                'address'        => $address,
                'note'           => $note,
                'subtotal'       => $subtotal,
                'shipping_fee'   => $shipping,
                'total'          => $total,
                'payment_method' => $payment,
            ], $orderItems);
        } catch (Exception $e) {
            $this->redirectWith('/checkout', 'error', 'Có lỗi xảy ra. Vui lòng thử lại.');
            return;
        }

        CartModel::clear($userId);
        $this->redirect('/order/success/' . $orderId);
    }

    public function success(array $p): void {
        Middleware::requireLogin();
        $order = OrderModel::getWithItems((int)($p['id'] ?? 0));
        if (!$order || (int)$order['user_id'] !== (int)$this->currentUser()['id']) {
            $this->redirect('/orders');
        }
        $this->render('order/success', compact('order') + [
            'title' => 'Đặt hàng thành công – ' . APP_NAME,
        ], 'main');
    }

    public function myOrders(array $p): void {
        Middleware::requireLogin();
        $userId = (int)$this->currentUser()['id'];
        $total  = OrderModel::countUserOrders($userId);
        $pg     = $this->paginate($total, 10);
        $orders = OrderModel::userOrders($userId, $pg['offset'], $pg['limit']);

        $this->render('order/list', compact('orders', 'pg') + [
            'title' => 'Đơn hàng của tôi – ' . APP_NAME,
            'empty' => empty($orders),
        ], 'main');
    }
}
