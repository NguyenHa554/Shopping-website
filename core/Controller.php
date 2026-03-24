<?php
// ============================================================
// SONNE – Base Controller
// ============================================================

abstract class Controller {

    // Render a view file with data
    protected function render(string $view, array $data = [], ?string $layout = 'main'): void {
        extract($data, EXTR_SKIP);

        // Collect view output
        ob_start();
        $viewFile = ROOT_PATH . '/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            ob_end_clean();
            die("View not found: {$view}");
        }
        require $viewFile;
        $content = ob_get_clean();

        if ($layout) {
            $layoutFile = ROOT_PATH . '/views/layouts/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
                return;
            }
        }
        // No layout – echo directly
        echo $content;
    }

    // Render admin view
    protected function renderAdmin(string $view, array $data = []): void {
        extract($data, EXTR_SKIP);
        ob_start();
        $viewFile = ROOT_PATH . '/views/admin/' . $view . '.php';
        if (!file_exists($viewFile)) {
            ob_end_clean();
            die("Admin view not found: {$view}");
        }
        require $viewFile;
        $content = ob_get_clean();
        $layoutFile = ROOT_PATH . '/views/admin/layouts/main.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    // Redirect
    protected function redirect(string $path): void {
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    // Redirect with flash message
    protected function redirectWith(string $path, string $type, string $message): void {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
        $this->redirect($path);
    }

    // JSON response
    protected function json(mixed $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Get current user from session
    protected function currentUser(): ?array {
        return $_SESSION['user'] ?? null;
    }

    // Check if user is logged in
    protected function isLoggedIn(): bool {
        return isset($_SESSION['user']);
    }

    // Check if user is admin
    protected function isAdmin(): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    // Require login (redirect if not)
    protected function requireLogin(): void {
        if (!$this->isLoggedIn()) {
            $this->redirectWith('/login', 'error', 'Vui lòng đăng nhập để tiếp tục.');
        }
    }

    // Require admin
    protected function requireAdmin(): void {
        if (!$this->isAdmin()) {
            http_response_code(403);
            die('403 Forbidden');
        }
    }

    // CSRF: generate token
    protected function csrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // CSRF: validate token
    protected function validateCsrf(): void {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            exit('Invalid CSRF token.');
        }
    }

    // Safe POST getter
    protected function post(string $key, string $default = ''): string {
        return trim($_POST[$key] ?? $default);
    }

    // Safe GET getter
    protected function get(string $key, string $default = ''): string {
        return trim($_GET[$key] ?? $default);
    }

    // Pagination helper
    protected function paginate(int $total, int $perPage = ITEMS_PER_PAGE): array {
        $page  = max(1, (int) ($this->get('page') ?: 1));
        $pages = (int) ceil($total / $perPage);
        $page  = min($page, max(1, $pages));
        return [
            'page'   => $page,
            'pages'  => $pages,
            'offset' => ($page - 1) * $perPage,
            'limit'  => $perPage,
            'total'  => $total,
        ];
    }
}
