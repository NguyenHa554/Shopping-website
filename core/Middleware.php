<?php
// ============================================================
// SONNE – Middleware (Auth guards as static helpers)
// Used inside controllers: Middleware::requireLogin();
// ============================================================

class Middleware {

    public static function requireLogin(): void {
        if (empty($_SESSION['user'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Vui lòng đăng nhập để tiếp tục.'];
            header('Location: ' . BASE_URL . '/login?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
    }

    public static function requireAdmin(): void {
        self::requireLogin();
        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            exit('<h1>403 – Access Denied</h1>');
        }
    }

    public static function requireGuest(): void {
        if (!empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
    }

    public static function validateCsrf(): void {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            exit('Invalid CSRF token.');
        }
    }
}
