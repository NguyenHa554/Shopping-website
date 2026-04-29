<?php
defined('SONNE_APP') or die('No direct access');

class ProductModel extends Model {
    protected static string $table = 'products';

    public static function findBySlug(string $slug): ?array {
        return DB::fetchOne(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             JOIN categories c ON p.category_id = c.id
             WHERE p.slug = ? AND p.deleted_at IS NULL AND p.status='active' LIMIT 1",
            [$slug]
        );
    }

    public static function featured(int $limit = 8): array {
        return DB::fetchAll(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
             FROM products p
             JOIN categories c ON p.category_id = c.id
             WHERE p.is_featured=1 AND p.status='active' AND p.deleted_at IS NULL 
             ORDER BY p.id DESC LIMIT ?",
            [$limit]
        );
    }

    public static function flashSale(int $limit = 8): array {
        return DB::fetchAll(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
             FROM products p
             JOIN categories c ON p.category_id = c.id
             WHERE p.is_flash_sale=1 AND p.flash_ends_at > NOW() AND p.status='active' AND p.deleted_at IS NULL 
             LIMIT ?",
            [$limit]
        );
    }

    public static function byCategory(int $catId, int $offset, int $limit): array {
        return DB::fetchAll(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
             FROM products p
             JOIN categories c ON p.category_id = c.id
             WHERE p.category_id=? AND p.status='active' AND p.deleted_at IS NULL 
             ORDER BY p.id DESC LIMIT ? OFFSET ?",
            [$catId, $limit, $offset]
        );
    }

    public static function countByCategory(int $catId): int {
        return DB::count("SELECT COUNT(*) FROM products WHERE category_id=? AND status='active' AND deleted_at IS NULL", [$catId]);
    }

    public static function search(string $kw, int $offset, int $limit, string $sort = 'newest'): array {
        $orderBy = match($sort) {
            'price_asc'  => 'COALESCE(p.sale_price, p.price) ASC',
            'price_desc' => 'COALESCE(p.sale_price, p.price) DESC',
            default      => 'p.id DESC',
        };
        return DB::fetchAll(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
             FROM products p
             JOIN categories c ON p.category_id = c.id
             WHERE p.status='active' AND p.deleted_at IS NULL
               AND (p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?)
             ORDER BY {$orderBy} LIMIT ? OFFSET ?",
            ["%$kw%", "%$kw%", "%$kw%", $limit, $offset]
        );
    }

    public static function countSearch(string $kw): int {
        return DB::count(
            "SELECT COUNT(*) FROM products p JOIN categories c ON p.category_id=c.id
             WHERE p.status='active' AND p.deleted_at IS NULL
               AND (p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?)",
            ["%$kw%", "%$kw%", "%$kw%"]
        );
    }

    public static function adminList(int $offset, int $limit, string $search = ''): array {
        $where = "p.deleted_at IS NULL";
        $params = [];
        if ($search) {
            $where .= " AND (p.name LIKE ? OR c.name LIKE ?)";
            $params = ["%$search%", "%$search%"];
        }
        $params[] = $limit;
        $params[] = $offset;
        return DB::fetchAll(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
             FROM products p
             JOIN categories c ON p.category_id=c.id
             WHERE {$where} ORDER BY p.id DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public static function adminCount(string $search = ''): int {
        if ($search) {
            return DB::count(
                "SELECT COUNT(*) FROM products p JOIN categories c ON p.category_id=c.id WHERE p.deleted_at IS NULL AND (p.name LIKE ? OR c.name LIKE ?)",
                ["%$search%", "%$search%"]
            );
        }
        return DB::count("SELECT COUNT(*) FROM products WHERE deleted_at IS NULL");
    }

    public static function getImages(int $productId): array {
        return DB::fetchAll(
            "SELECT * FROM product_images WHERE product_id=? ORDER BY sort_order",
            [$productId]
        );
    }

    public static function addImage(int $productId, string $path, int $sort = 0): void {
        DB::execute("INSERT INTO product_images (product_id, image_path, sort_order) VALUES (?,?,?)", [$productId, $path, $sort]);
    }

    public static function deleteImages(int $productId): array {
        $images = DB::fetchAll("SELECT image_path FROM product_images WHERE product_id=?", [$productId]);
        DB::execute("DELETE FROM product_images WHERE product_id=?", [$productId]);
        return $images;
    }

    public static function softDelete(int $id): void {
        DB::execute("UPDATE products SET deleted_at=NOW() WHERE id=?", [$id]);
    }

    public static function related(int $catId, int $excludeId, int $limit = 4): array {
        return DB::fetchAll(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
             FROM products p
             JOIN categories c ON p.category_id = c.id
             WHERE p.category_id=? AND p.id!=? AND p.status='active' AND p.deleted_at IS NULL 
             ORDER BY RAND() LIMIT ?",
            [$catId, $excludeId, $limit]
        );
    }

    public static function decreaseStock(int $id, int $qty): void {
        DB::execute("UPDATE products SET stock = stock - ? WHERE id=? AND stock >= ?", [$qty, $id, $qty]);
    }
}
