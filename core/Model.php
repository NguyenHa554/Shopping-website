<?php
// ============================================================
// SONNE – Base Model
// ============================================================

abstract class Model {
    protected static string $table = '';
    protected static string $primaryKey = 'id';

    public static function find(int $id): ?array {
        return DB::fetchOne(
            "SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = ? LIMIT 1",
            [$id]
        );
    }

    public static function all(string $orderBy = 'id DESC'): array {
        return DB::fetchAll("SELECT * FROM " . static::$table . " ORDER BY {$orderBy}");
    }

    public static function create(array $data): int {
        $cols   = implode(', ', array_keys($data));
        $places = implode(', ', array_fill(0, count($data), '?'));
        return DB::insert(
            "INSERT INTO " . static::$table . " ({$cols}) VALUES ({$places})",
            array_values($data)
        );
    }

    public static function update(int $id, array $data): int {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        return DB::execute(
            "UPDATE " . static::$table . " SET {$set} WHERE " . static::$primaryKey . " = ?",
            [...array_values($data), $id]
        );
    }

    public static function delete(int $id): int {
        return DB::execute(
            "DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?",
            [$id]
        );
    }

    public static function count(string $where = '', array $params = []): int {
        $sql = "SELECT COUNT(*) FROM " . static::$table;
        if ($where) $sql .= " WHERE {$where}";
        return DB::count($sql, $params);
    }
}
