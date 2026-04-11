<?php
defined('SONNE_APP') or die('No direct access');

class NewsModel extends Model {
    protected static string $table = 'news';

    public static function published(int $offset, int $limit, string $search = ''): array {
        $where  = "n.status='published' AND n.deleted_at IS NULL";
        $params = [];
        if ($search) {
            $where  .= " AND (n.title LIKE ? OR n.summary LIKE ?)";
            $params  = ["%$search%", "%$search%"];
        }
        $params[] = $limit;
        $params[] = $offset;
        return DB::fetchAll(
            "SELECT n.*, u.full_name AS author_name FROM news n LEFT JOIN users u ON u.id=n.author_id
             WHERE {$where} ORDER BY n.published_at DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public static function countPublished(string $search = ''): int {
        if ($search) {
            return DB::count(
                "SELECT COUNT(*) FROM news WHERE status='published' AND deleted_at IS NULL AND (title LIKE ? OR summary LIKE ?)",
                ["%$search%", "%$search%"]
            );
        }
        return DB::count("SELECT COUNT(*) FROM news WHERE status='published' AND deleted_at IS NULL");
    }

    public static function findBySlug(string $slug): ?array {
        return DB::fetchOne(
            "SELECT n.*, u.full_name AS author_name FROM news n LEFT JOIN users u ON u.id=n.author_id
             WHERE n.slug=? AND n.status='published' AND n.deleted_at IS NULL LIMIT 1",
            [$slug]
        );
    }

    public static function getComments(int $newsId): array {
        return DB::fetchAll(
            "SELECT nc.*, u.full_name, u.avatar FROM news_comments nc JOIN users u ON u.id=nc.user_id
             WHERE nc.news_id=? AND nc.is_deleted=0 ORDER BY nc.created_at",
            [$newsId]
        );
    }

    public static function addComment(int $newsId, int $userId, string $comment): void {
        DB::execute("INSERT INTO news_comments (news_id, user_id, comment) VALUES (?,?,?)", [$newsId, $userId, $comment]);
    }

    public static function deleteComment(int $id): void {
        DB::execute("UPDATE news_comments SET is_deleted=1 WHERE id=?", [$id]);
    }

    public static function adminComments(int $offset, int $limit, string $search = ''): array {
        $where  = "nc.is_deleted=0";
        $params = [];
        if ($search) {
            $where  .= " AND (n.title LIKE ? OR u.full_name LIKE ? OR nc.comment LIKE ?)";
            $params  = ["%$search%", "%$search%", "%$search%"];
        }
        $params[] = $limit;
        $params[] = $offset;

        return DB::fetchAll(
            "SELECT nc.*, n.title AS news_title, n.slug AS news_slug, u.full_name AS user_name
             FROM news_comments nc
             JOIN news n ON n.id=nc.news_id
             JOIN users u ON u.id=nc.user_id
             WHERE {$where}
             ORDER BY nc.id DESC
             LIMIT ? OFFSET ?",
            $params
        );
    }

    public static function adminCommentCount(string $search = ''): int {
        if ($search) {
            return DB::count(
                "SELECT COUNT(*)
                 FROM news_comments nc
                 JOIN news n ON n.id=nc.news_id
                 JOIN users u ON u.id=nc.user_id
                 WHERE nc.is_deleted=0 AND (n.title LIKE ? OR u.full_name LIKE ? OR nc.comment LIKE ?)",
                ["%$search%", "%$search%", "%$search%"]
            );
        }
        return DB::count("SELECT COUNT(*) FROM news_comments WHERE is_deleted=0");
    }

    public static function adminList(int $offset, int $limit, string $search = ''): array {
        $where  = "n.deleted_at IS NULL";
        $params = [];
        if ($search) { $where .= " AND n.title LIKE ?"; $params = ["%$search%"]; }
        $params[] = $limit; $params[] = $offset;
        return DB::fetchAll("SELECT n.*, u.full_name AS author_name FROM news n LEFT JOIN users u ON u.id=n.author_id WHERE {$where} ORDER BY n.id DESC LIMIT ? OFFSET ?", $params);
    }

    public static function adminCount(string $search = ''): int {
        if ($search) return DB::count("SELECT COUNT(*) FROM news WHERE deleted_at IS NULL AND title LIKE ?", ["%$search%"]);
        return DB::count("SELECT COUNT(*) FROM news WHERE deleted_at IS NULL");
    }

    public static function softDelete(int $id): void {
        DB::execute("UPDATE news SET deleted_at=NOW() WHERE id=?", [$id]);
    }
}
