<?php
defined('SONNE_APP') or die('No direct access');

class CategoryModel extends Model {
    protected static string $table = 'categories';

    public static function findBySlug(string $slug): ?array {
        return DB::fetchOne("SELECT * FROM categories WHERE slug=? LIMIT 1", [$slug]);
    }

    public static function allWithCount(): array {
        return DB::fetchAll(
            "SELECT c.*, COUNT(p.id) AS product_count
             FROM categories c
             LEFT JOIN products p ON p.category_id=c.id AND p.status='active' AND p.deleted_at IS NULL
             GROUP BY c.id ORDER BY c.sort_order"
        );
    }
}
