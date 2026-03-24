<?php
// ============================================================
// SONNE – Database Connection (PDO Singleton)
// ============================================================

class DB {
    private static ?PDO $instance = null;

    private static string $host     = '127.0.0.1';
    private static string $dbname   = 'sonne_db';
    private static string $user     = 'root';
    private static string $password = '';   // XAMPP default
    private static string $charset  = 'utf8mb4';

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . self::$host
                 . ";dbname=" . self::$dbname
                 . ";charset=" . self::$charset;
            try {
                self::$instance = new PDO($dsn, self::$user, self::$password, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                // Never expose raw error in production
                error_log('[DB] Connection failed: ' . $e->getMessage());
                http_response_code(500);
                exit('Service temporarily unavailable. Please try again later.');
            }
        }
        return self::$instance;
    }

    // Convenience: run a SELECT and return all rows
    public static function fetchAll(string $sql, array $params = []): array {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Convenience: run a SELECT and return one row
    public static function fetchOne(string $sql, array $params = []): ?array {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }

    // Convenience: execute INSERT/UPDATE/DELETE
    public static function execute(string $sql, array $params = []): int {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->rowCount();
    }

    // Convenience: INSERT and return last insert ID
    public static function insert(string $sql, array $params = []): int {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return (int) self::getInstance()->lastInsertId();
    }

    // Count helper
    public static function count(string $sql, array $params = []): int {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }
}
