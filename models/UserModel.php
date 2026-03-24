<?php
defined('SONNE_APP') or die('No direct access');

class UserModel extends Model {
    protected static string $table = 'users';

    public static function findByEmail(string $email): ?array {
        return DB::fetchOne("SELECT * FROM users WHERE email = ? AND deleted_at IS NULL LIMIT 1", [$email]);
    }

    public static function findActive(int $id): ?array {
        return DB::fetchOne("SELECT * FROM users WHERE id = ? AND deleted_at IS NULL LIMIT 1", [$id]);
    }

    public static function paginate(int $offset, int $limit, string $search = ''): array {
        if ($search) {
            return DB::fetchAll(
                "SELECT * FROM users WHERE deleted_at IS NULL AND (full_name LIKE ? OR email LIKE ?) ORDER BY id DESC LIMIT ? OFFSET ?",
                ["%$search%", "%$search%", $limit, $offset]
            );
        }
        return DB::fetchAll("SELECT * FROM users WHERE deleted_at IS NULL ORDER BY id DESC LIMIT ? OFFSET ?", [$limit, $offset]);
    }

    public static function countAll(string $search = ''): int {
        if ($search) {
            return DB::count("SELECT COUNT(*) FROM users WHERE deleted_at IS NULL AND (full_name LIKE ? OR email LIKE ?)", ["%$search%", "%$search%"]);
        }
        return DB::count("SELECT COUNT(*) FROM users WHERE deleted_at IS NULL");
    }

    public static function register(array $data): int {
        return static::create([
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'password'  => password_hash($data['password'], PASSWORD_BCRYPT),
            'phone'     => $data['phone'] ?? null,
            'role'      => 'member',
        ]);
    }

    public static function updateProfile(int $id, array $data): int {
        return DB::execute(
            "UPDATE users SET full_name=?, phone=?, address=? WHERE id=?",
            [$data['full_name'], $data['phone'] ?? null, $data['address'] ?? null, $id]
        );
    }

    public static function updateAvatar(int $id, string $path): int {
        return DB::execute("UPDATE users SET avatar=? WHERE id=?", [$path, $id]);
    }

    public static function updatePassword(int $id, string $newHash): int {
        return DB::execute("UPDATE users SET password=? WHERE id=?", [$newHash, $id]);
    }

    public static function toggleLock(int $id): void {
        DB::execute("UPDATE users SET is_locked = NOT is_locked WHERE id=?", [$id]);
    }

    public static function softDelete(int $id): void {
        DB::execute("UPDATE users SET deleted_at=NOW() WHERE id=?", [$id]);
    }

    public static function incrementLoginAttempts(string $email): void {
        DB::execute("UPDATE users SET login_attempts = login_attempts + 1 WHERE email=?", [$email]);
    }

    public static function lockUntil(string $email, string $until): void {
        DB::execute("UPDATE users SET locked_until=? WHERE email=?", [$until, $email]);
    }

    public static function resetLoginAttempts(int $id): void {
        DB::execute("UPDATE users SET login_attempts=0, locked_until=NULL WHERE id=?", [$id]);
    }
}
