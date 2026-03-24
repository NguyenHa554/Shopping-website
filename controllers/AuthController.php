<?php
defined('SONNE_APP') or die('No direct access');

class AuthController extends Controller {

    public function loginForm(array $p): void {
        Middleware::requireGuest();
        $this->render('user/login', ['title' => 'Đăng nhập – ' . APP_NAME]);
    }

    public function login(array $p): void {
        Middleware::requireGuest();
        Middleware::validateCsrf();

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Basic validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !$password) {
            $this->redirectWith('/login', 'error', 'Email hoặc mật khẩu không hợp lệ.');
            return;
        }

        $user = UserModel::findByEmail($email);

        if (!$user) {
            $this->redirectWith('/login', 'error', 'Email không tồn tại trong hệ thống.');
            return;
        }

        // Check lock
        if ($user['is_locked']) {
            $this->redirectWith('/login', 'error', 'Tài khoản đã bị khóa. Vui lòng liên hệ hỗ trợ.');
            return;
        }

        // Temp lockout (brute-force)
        if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
            $this->redirectWith('/login', 'error', 'Bạn đã đăng nhập sai quá nhiều lần. Vui lòng thử lại sau 30 giây.');
            return;
        }

        if (!password_verify($password, $user['password'])) {
            UserModel::incrementLoginAttempts($email);
            if (($user['login_attempts'] + 1) >= 5) {
                UserModel::lockUntil($email, date('Y-m-d H:i:s', time() + 30));
            }
            $this->redirectWith('/login', 'error', 'Mật khẩu không đúng.');
            return;
        }

        // Success
        UserModel::resetLoginAttempts((int)$user['id']);
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'        => $user['id'],
            'full_name' => $user['full_name'],
            'email'     => $user['email'],
            'avatar'    => $user['avatar'],
            'role'      => $user['role'],
        ];

        // Redirect back or home
        $redirect = $_GET['redirect'] ?? '/';
        $this->redirect($redirect);
    }

    public function registerForm(array $p): void {
        Middleware::requireGuest();
        $this->render('user/register', ['title' => 'Đăng ký – ' . APP_NAME]);
    }

    public function register(array $p): void {
        Middleware::requireGuest();
        Middleware::validateCsrf();

        $name     = trim($_POST['full_name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        $errors = [];
        if (mb_strlen($name) < 2)                              $errors[] = 'Họ tên phải có ít nhất 2 ký tự.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))        $errors[] = 'Email không hợp lệ.';
        if (mb_strlen($password) < 8)                          $errors[] = 'Mật khẩu phải ít nhất 8 ký tự.';
        if ($password !== $confirm)                            $errors[] = 'Xác nhận mật khẩu không khớp.';
        if (UserModel::findByEmail($email))                    $errors[] = 'Email này đã được đăng ký.';

        if ($errors) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => implode(' ', $errors)];
            $_SESSION['form']  = compact('name', 'email', 'phone');
            $this->redirect('/register');
            return;
        }

        $id = UserModel::register(compact('name', 'phone') + ['full_name' => $name, 'email' => $email, 'password' => $password]);
        $user = UserModel::findActive($id);
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'        => $user['id'],
            'full_name' => $user['full_name'],
            'email'     => $user['email'],
            'avatar'    => null,
            'role'      => 'member',
        ];
        $this->redirectWith('/', 'success', 'Đăng ký thành công! Chào mừng đến SONNE.');
    }

    public function logout(array $p): void {
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
