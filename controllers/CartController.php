<?php
defined('SONNE_APP') or die('No direct access');

class CartController extends Controller {

    public function index(array $p): void {
        if ($this->isLoggedIn()) {
            $items = CartModel::getItems((int)$this->currentUser()['id']);
        } else {
            $items = []; // guest uses localStorage, rendered by JS
        }
        $this->render('cart/index', compact('items') + [
            'title' => 'Giỏ hàng – ' . APP_NAME,
        ], 'main');
    }

    // AJAX: add item to cart
    public function add(array $p): void {
        $this->validateCsrf();
        if (!$this->isLoggedIn()) {
            $this->json(['status' => 'guest'], 401);
            return;
        }
        $pid = (int) ($this->post('product_id') ?: 0);
        $qty = max(1, (int) ($this->post('quantity') ?: 1));
        if (!$pid) { $this->json(['error' => 'Invalid product'], 400); return; }

        $product = DB::fetchOne("SELECT id, stock FROM products WHERE id=? AND status='active' AND deleted_at IS NULL", [$pid]);
        if (!$product) { $this->json(['error' => 'Product not found'], 404); return; }
        if ($product['stock'] < $qty) { $this->json(['error' => 'Không đủ hàng'], 422); return; }

        CartModel::addOrUpdate((int)$this->currentUser()['id'], $pid, $qty);
        $count = CartModel::countItems((int)$this->currentUser()['id']);
        $this->json(['status' => 'ok', 'count' => $count]);
    }

    // AJAX: update quantity
    public function update(array $p): void {
        $this->validateCsrf();
        Middleware::requireLogin();
        $pid = (int) $this->post('product_id');
        $qty = (int) $this->post('quantity');
        CartModel::setQuantity((int)$this->currentUser()['id'], $pid, $qty);
        $this->json(['status' => 'ok', 'count' => CartModel::countItems((int)$this->currentUser()['id'])]);
    }

    // AJAX: remove item
    public function remove(array $p): void {
        $this->validateCsrf();
        Middleware::requireLogin();
        $pid = (int) $this->post('product_id');
        CartModel::removeItem((int)$this->currentUser()['id'], $pid);
        $this->json(['status' => 'ok', 'count' => CartModel::countItems((int)$this->currentUser()['id'])]);
    }

    // AJAX: clear cart
    public function clear(array $p): void {
        $this->validateCsrf();
        Middleware::requireLogin();
        CartModel::clear((int)$this->currentUser()['id']);
        $this->json(['status' => 'ok', 'count' => 0]);
    }

    // AJAX: sync guest cart (called after login)
    public function sync(array $p): void {
        Middleware::requireLogin();
        $raw   = $_POST['cart'] ?? '[]';
        $items = json_decode($raw, true) ?: [];
        CartModel::mergeGuest((int)$this->currentUser()['id'], $items);
        $count = CartModel::countItems((int)$this->currentUser()['id']);
        $this->json(['status' => 'ok', 'count' => $count]);
    }

    // AJAX: return cart item count (for nav badge)
    public function count(array $p): void {
        if (!$this->isLoggedIn()) { $this->json(['count' => 0]); return; }
        $this->json(['count' => CartModel::countItems((int)$this->currentUser()['id'])]);
    }
}
