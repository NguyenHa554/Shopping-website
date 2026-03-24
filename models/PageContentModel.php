<?php
defined('SONNE_APP') or die('No direct access');

class PageContentModel extends Model {
    protected static string $table = 'page_contents';

    public static function get(string $key): ?array {
        return DB::fetchOne("SELECT * FROM page_contents WHERE page_key=? LIMIT 1", [$key]);
    }

    public static function getValue(string $key, string $field = 'content'): string {
        $row = self::get($key);
        return $row[$field] ?? '';
    }

    public static function upsert(string $key, ?string $title, ?string $content, ?string $image = null): void {
        $existing = self::get($key);
        if ($existing) {
            DB::execute(
                "UPDATE page_contents SET title=?, content=?, image=COALESCE(?,image) WHERE page_key=?",
                [$title, $content, $image, $key]
            );
        } else {
            DB::execute(
                "INSERT INTO page_contents (page_key, title, content, image) VALUES (?,?,?,?)",
                [$key, $title, $content, $image]
            );
        }
    }

    public static function allAsMap(): array {
        $rows = DB::fetchAll("SELECT * FROM page_contents");
        $map = [];
        foreach ($rows as $r) $map[$r['page_key']] = $r;
        return $map;
    }
}
