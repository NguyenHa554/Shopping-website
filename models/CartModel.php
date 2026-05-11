<?php
defined('SONNE_APP') or die('No direct access');

class CartModel extends Model {
    protected static string $table = 'cart_items';

    private static function ensureAdminStatusTable(): void {
        DB::execute(
            "CREATE TABLE IF NOT EXISTS cart_admin_statuses (
                user_id INT UNSIGNED NOT NULL PRIMARY KEY,
                status ENUM('active','abandoned','contacted','archived') NOT NULL DEFAULT 'active',
                note TEXT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_cart_admin_statuses_user FOREIGN KEY (user_id) REFERENCES users(id)
                    ON UPDATE CASCADE ON DELETE CASCADE,
                INDEX idx_cart_admin_statuses_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
    }

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

    public static function adminCount(string $status = '', string $search = ''): int {
        self::ensureAdminStatusTable();

        $where = ["p.deleted_at IS NULL"];
        $params = [];

        if ($status !== '') {
            $where[] = "COALESCE(cas.status, 'active') = ?";
            $params[] = $status;
        }

        if ($search !== '') {
            $where[] = "(u.full_name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        return DB::count(
            "SELECT COUNT(DISTINCT ci.user_id)
             FROM cart_items ci
             JOIN users u ON u.id = ci.user_id
             JOIN products p ON p.id = ci.product_id
             LEFT JOIN cart_admin_statuses cas ON cas.user_id = ci.user_id
             WHERE " . implode(' AND ', $where),
            $params
        );
    }

    public static function adminList(int $offset, int $limit, string $status = '', string $search = ''): array {
        self::ensureAdminStatusTable();

        $where = ["p.deleted_at IS NULL"];
        $params = [];

        if ($status !== '') {
            $where[] = "COALESCE(cas.status, 'active') = ?";
            $params[] = $status;
        }

        if ($search !== '') {
            $where[] = "(u.full_name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $params[] = $limit;
        $params[] = $offset;

        return DB::fetchAll(
            "SELECT
                ci.user_id,
                u.full_name,
                u.email,
                u.phone,
                COUNT(DISTINCT ci.product_id) AS product_count,
                COALESCE(SUM(ci.quantity), 0) AS total_quantity,
                COALESCE(SUM(COALESCE(NULLIF(p.sale_price, 0), p.price) * ci.quantity), 0) AS total_value,
                MAX(ci.added_at) AS last_added_at,
                COALESCE(cas.status, 'active') AS status,
                cas.updated_at AS status_updated_at
             FROM cart_items ci
             JOIN users u ON u.id = ci.user_id
             JOIN products p ON p.id = ci.product_id
             LEFT JOIN cart_admin_statuses cas ON cas.user_id = ci.user_id
             WHERE " . implode(' AND ', $where) . "
             GROUP BY ci.user_id, u.full_name, u.email, u.phone, cas.status, cas.updated_at
             ORDER BY last_added_at DESC
             LIMIT ? OFFSET ?",
            $params
        );
    }

    public static function adminDetail(int $userId): ?array {
        self::ensureAdminStatusTable();

        $cart = DB::fetchOne(
            "SELECT
                u.id AS user_id,
                u.full_name,
                u.email,
                u.phone,
                u.address,
                COALESCE(SUM(ci.quantity), 0) AS total_quantity,
                COUNT(DISTINCT ci.product_id) AS product_count,
                COALESCE(SUM(COALESCE(NULLIF(p.sale_price, 0), p.price) * ci.quantity), 0) AS total_value,
                MAX(ci.added_at) AS last_added_at,
                COALESCE(cas.status, 'active') AS status,
                cas.note,
                cas.updated_at AS status_updated_at
             FROM cart_items ci
             JOIN users u ON u.id = ci.user_id
             JOIN products p ON p.id = ci.product_id
             LEFT JOIN cart_admin_statuses cas ON cas.user_id = ci.user_id
             WHERE ci.user_id = ? AND p.deleted_at IS NULL
             GROUP BY u.id, u.full_name, u.email, u.phone, u.address, cas.status, cas.note, cas.updated_at
             LIMIT 1",
            [$userId]
        );

        if (!$cart) {
            return null;
        }

        $cart['items'] = DB::fetchAll(
            "SELECT
                ci.product_id,
                ci.quantity,
                ci.added_at,
                p.name,
                p.slug,
                p.price,
                p.sale_price,
                p.stock,
                p.cover_image
             FROM cart_items ci
             JOIN products p ON p.id = ci.product_id
             WHERE ci.user_id = ? AND p.deleted_at IS NULL
             ORDER BY ci.added_at DESC",
            [$userId]
        );

        return $cart;
    }

    public static function updateAdminStatus(int $userId, string $status, ?string $note = null): void {
        self::ensureAdminStatusTable();
        DB::execute(
            "INSERT INTO cart_admin_statuses (user_id, status, note)
             VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE status = VALUES(status), note = VALUES(note), updated_at = CURRENT_TIMESTAMP",
            [$userId, $status, $note]
        );
    }
}
