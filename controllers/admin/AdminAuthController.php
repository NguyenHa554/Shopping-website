<?php
defined('SONNE_APP') or die('No direct access');

class AdminAuthController extends Controller {
    public function loginForm(array $p): void {
        Middleware::requireGuest();
        require ROOT_PATH . '/views/admin/auth/login.php';
    }
    public function login(array $p): void {
        Middleware::requireGuest();
        Middleware::validateCsrf();
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user     = UserModel::findByEmail($email);
        if (!$user || $user['role'] !== 'admin' || !password_verify($password, $user['password'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Thông tin đăng nhập không đúng.'];
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }
        if ($user['is_locked']) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Tài khoản bị khóa.'];
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $user['id'], 'full_name' => $user['full_name'],
            'email' => $user['email'], 'avatar' => $user['avatar'], 'role' => 'admin',
        ];
        header('Location: ' . BASE_URL . '/admin/dashboard');
        exit;
    }
    public function logout(array $p): void {
        session_destroy();
        header('Location: ' . BASE_URL . '/admin/login');
        exit;
    }
}
