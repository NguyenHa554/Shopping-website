<?php
defined('SONNE_APP') or die('No direct access');

class OrderModel extends Model {
    protected static string $table = 'orders';

    public static function createOrder(array $data, array $items): int {
        $pdo = DB::getInstance();
        $pdo->beginTransaction();
        try {
            $orderId = DB::insert(
                "INSERT INTO orders (user_id,full_name,email,phone,address,note,subtotal,shipping_fee,total,payment_method)
                 VALUES (?,?,?,?,?,?,?,?,?,?)",
                [
                    $data['user_id'] ?? null,
                    $data['full_name'], $data['email'], $data['phone'],
                    $data['address'], $data['note'] ?? null,
                    $data['subtotal'], $data['shipping_fee'], $data['total'],
                    $data['payment_method'] ?? 'cod',
                ]
            );
            foreach ($items as $item) {
                DB::execute(
                    "INSERT INTO order_items (order_id,product_id,product_name,cover_image,price,quantity) VALUES (?,?,?,?,?,?)",
                    [$orderId, $item['product_id'], $item['name'], $item['cover_image'] ?? null, $item['unit_price'], $item['quantity']]
                );
                ProductModel::decreaseStock((int)$item['product_id'], (int)$item['quantity']);
            }
            $pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function getWithItems(int $id): ?array {
        $order = DB::fetchOne("SELECT * FROM orders WHERE id=?", [$id]);
        if (!$order) return null;
        $order['items'] = DB::fetchAll("SELECT * FROM order_items WHERE order_id=?", [$id]);
        return $order;
    }

    public static function userOrders(int $userId, int $offset, int $limit): array {
        return DB::fetchAll(
            "SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC LIMIT ? OFFSET ?",
            [$userId, $limit, $offset]
        );
    }

    public static function countUserOrders(int $userId): int {
        return DB::count("SELECT COUNT(*) FROM orders WHERE user_id=?", [$userId]);
    }

    public static function adminList(int $offset, int $limit, string $status = ''): array {
        $where  = $status ? "WHERE o.status=?" : "";
        $params = $status ? [$status, $limit, $offset] : [$limit, $offset];
        return DB::fetchAll(
            "SELECT o.*, u.full_name AS user_name FROM orders o LEFT JOIN users u ON u.id=o.user_id {$where} ORDER BY o.id DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public static function adminCount(string $status = ''): int {
        if ($status) return DB::count("SELECT COUNT(*) FROM orders WHERE status=?", [$status]);
        return DB::count("SELECT COUNT(*) FROM orders");
    }

    public static function updateStatus(int $id, string $status): void {
        DB::execute("UPDATE orders SET status=? WHERE id=?", [$status, $id]);
    }
}
