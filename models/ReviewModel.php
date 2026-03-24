<?php
defined('SONNE_APP') or die('No direct access');

class ReviewModel extends Model {
    protected static string $table = 'reviews';

    public static function forProduct(int $productId): array {
        return DB::fetchAll(
            "SELECT r.*, u.full_name, u.avatar FROM reviews r JOIN users u ON u.id=r.user_id
             WHERE r.product_id=? AND r.is_deleted=0 ORDER BY r.created_at DESC",
            [$productId]
        );
    }

    public static function averageRating(int $productId): float {
        $avg = DB::fetchOne("SELECT AVG(rating) AS avg FROM reviews WHERE product_id=? AND is_deleted=0", [$productId]);
        return round((float)($avg['avg'] ?? 0), 1);
    }

    public static function upsert(int $productId, int $userId, int $rating, string $comment): void {
        DB::execute(
            "INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?,?,?,?)
             ON DUPLICATE KEY UPDATE rating=VALUES(rating), comment=VALUES(comment), updated_at=NOW()",
            [$productId, $userId, $rating, $comment]
        );
    }

    public static function adminList(int $offset, int $limit): array {
        return DB::fetchAll(
            "SELECT r.*, u.full_name, p.name AS product_name FROM reviews r
             JOIN users u ON u.id=r.user_id JOIN products p ON p.id=r.product_id
             WHERE r.is_deleted=0 ORDER BY r.id DESC LIMIT ? OFFSET ?",
            [$limit, $offset]
        );
    }

    public static function adminCount(): int {
        return DB::count("SELECT COUNT(*) FROM reviews WHERE is_deleted=0");
    }

    public static function softDelete(int $id): void {
        DB::execute("UPDATE reviews SET is_deleted=1 WHERE id=?", [$id]);
    }
}
