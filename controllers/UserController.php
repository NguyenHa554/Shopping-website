<?php
defined('SONNE_APP') or die('No direct access');

class UserController extends Controller {

    public function profile(array $p): void {
        Middleware::requireLogin();
        $userId = (int)$this->currentUser()['id'];
        $user   = UserModel::findActive($userId);
        if (!$user) { session_destroy(); $this->redirect('/login'); }

        $total  = OrderModel::countUserOrders($userId);
        $pg     = $this->paginate($total, 5);
        $orders = OrderModel::userOrders($userId, $pg['offset'], $pg['limit']);

        $this->render('user/profile', compact('user', 'orders', 'pg') + [
            'title' => 'Hồ sơ – ' . APP_NAME,
        ], 'main');
    }

    public function updateProfile(array $p): void {
        Middleware::requireLogin();
        $this->validateCsrf();
        $userId   = (int)$this->currentUser()['id'];
        $fullName = trim($_POST['full_name'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $address  = trim($_POST['address'] ?? '');

        if (mb_strlen($fullName) < 2) {
            $this->redirectWith('/profile', 'error', 'Họ tên không hợp lệ.');
            return;
        }

        UserModel::updateProfile($userId, compact('full_name', 'phone', 'address') + ['full_name' => $fullName]);

        // Refresh session user
        $user = UserModel::findActive($userId);
        $_SESSION['user']['full_name'] = $user['full_name'];

        $this->redirectWith('/profile', 'success', 'Cập nhật thông tin thành công.');
    }

    public function changePassword(array $p): void {
        Middleware::requireLogin();
        $this->validateCsrf();
        $userId  = (int)$this->currentUser()['id'];
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $user = UserModel::findActive($userId);
        if (!password_verify($current, $user['password'])) {
            $this->redirectWith('/profile', 'error', 'Mật khẩu hiện tại không đúng.');
            return;
        }
        if (mb_strlen($new) < 8) {
            $this->redirectWith('/profile', 'error', 'Mật khẩu mới phải ít nhất 8 ký tự.');
            return;
        }
        if ($new !== $confirm) {
            $this->redirectWith('/profile', 'error', 'Xác nhận mật khẩu không khớp.');
            return;
        }

        UserModel::updatePassword($userId, password_hash($new, PASSWORD_BCRYPT));
        $this->redirectWith('/profile', 'success', 'Đổi mật khẩu thành công.');
    }

    public function uploadAvatar(array $p): void {
        Middleware::requireLogin();
        $this->validateCsrf();
        $userId = (int)$this->currentUser()['id'];
        $file   = $_FILES['avatar'] ?? null;
        if (!$file) { $this->redirectWith('/profile', 'error', 'Không có file được chọn.'); return; }

        $path = handleImageUpload($file, 'avatars');
        if (!$path) {
            $this->redirectWith('/profile', 'error', 'File không hợp lệ. Vui lòng chọn ảnh JPG/PNG/WebP tối đa 5MB.');
            return;
        }

        // Delete old avatar
        $user = UserModel::findActive($userId);
        if ($user['avatar']) deleteUpload($user['avatar']);

        UserModel::updateAvatar($userId, $path);
        $_SESSION['user']['avatar'] = $path;
        $this->redirectWith('/profile', 'success', 'Cập nhật ảnh đại diện thành công.');
    }
}
