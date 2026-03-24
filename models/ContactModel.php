<?php
defined('SONNE_APP') or die('No direct access');

class ContactModel extends Model {
    protected static string $table = 'contacts';

    public static function adminList(int $offset, int $limit, string $status = ''): array {
        $where  = $status ? "WHERE status=?" : "";
        $params = $status ? [$status, $limit, $offset] : [$limit, $offset];
        return DB::fetchAll("SELECT * FROM contacts {$where} ORDER BY id DESC LIMIT ? OFFSET ?", $params);
    }

    public static function adminCount(string $status = ''): int {
        if ($status) return DB::count("SELECT COUNT(*) FROM contacts WHERE status=?", [$status]);
        return DB::count("SELECT COUNT(*) FROM contacts");
    }

    public static function updateStatus(int $id, string $status): void {
        DB::execute("UPDATE contacts SET status=? WHERE id=?", [$status, $id]);
    }
}
