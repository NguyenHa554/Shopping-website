<?php
defined('SONNE_APP') or die('No direct access');

class CartModel extends Model {
    protected static string $table = 'cart_items';

    public static function getItems(int $userId): array {
        return DB::fetchAll(
            "SELECT ci.*, p.name, p.slug, p.price, p.sale_price, p.stock, p.cover_image
             FROM cart_items ci
             JOIN products p ON p.id = ci.product_id
             WHERE ci.user_id = ? AND p.deleted_at IS NULL ORDER BY ci.added_at DESC",
            [$userId]
        );
    }

    public static function addOrUpdate(int $userId, int $productId, int $qty = 1): void {
        DB::execute(
            "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?,?,?)
             ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)",
            [$userId, $productId, $qty]
        );
    }

    public static function setQuantity(int $userId, int $productId, int $qty): void {
        if ($qty <= 0) {
            self::removeItem($userId, $productId);
            return;
        }
        DB::execute(
            "UPDATE cart_items SET quantity=? WHERE user_id=? AND product_id=?",
            [$qty, $userId, $productId]
        );
    }

    public static function removeItem(int $userId, int $productId): void {
        DB::execute("DELETE FROM cart_items WHERE user_id=? AND product_id=?", [$userId, $productId]);
    }

    public static function clear(int $userId): void {
        DB::execute("DELETE FROM cart_items WHERE user_id=?", [$userId]);
    }

    public static function countItems(int $userId): int {
        return (int) DB::fetchOne(
            "SELECT COALESCE(SUM(quantity),0) FROM cart_items WHERE user_id=?",
            [$userId]
        );
    }

    // Merge guest cart (from localStorage JSON array) into DB cart
    public static function mergeGuest(int $userId, array $items): void {
        foreach ($items as $item) {
            $pid = (int) ($item['id'] ?? 0);
            $qty = max(1, (int) ($item['quantity'] ?? 1));
            if ($pid > 0) self::addOrUpdate($userId, $pid, $qty);
        }
    }
}
