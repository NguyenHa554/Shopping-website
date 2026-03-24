<?php
// Admin Login view — standalone page (no sidebar)
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập – SONNE Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/admin/admin.css">
    <style>
        .admin-login-page { min-height:100vh; display:flex; align-items:center; justify-content:center;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); }
        .admin-login-card { background:#fff; border-radius:16px; padding:40px; width:100%; max-width:420px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3); }
        .login-brand { text-align:center; margin-bottom:32px; }
        .login-brand .logo { font-size:2rem; font-weight:800; letter-spacing:3px;
            background: linear-gradient(135deg,#6c63ff,#a855f7); -webkit-background-clip:text;
            -webkit-text-fill-color:transparent; }
        .login-brand p { color:#888; font-size:.9rem; margin:6px 0 0; }
    </style>
</head>
<body class="admin-body">
<div class="admin-login-page">
    <div class="admin-login-card">
        <div class="login-brand">
            <div class="logo">SONNE</div>
            <p>Admin Panel</p>
        </div>

        <?php $flash = flash(); if ($flash): ?>
        <div class="flash-banner flash-<?= e($flash['type']) ?>">
            <?= e($flash['message']) ?>
            <button onclick="this.parentElement.remove()"><i class="fa fa-times"></i></button>
        </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/admin/login" method="POST">
            <?= csrfField() ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                       placeholder="admin@sonne.vn" required autocomplete="email">
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px">
                <i class="fa fa-sign-in-alt"></i> Đăng nhập
            </button>
        </form>

        <div style="text-align:center;margin-top:20px;">
            <a href="<?= BASE_URL ?>/" style="color:#888;font-size:.85rem;text-decoration:none;">
                <i class="fa fa-arrow-left"></i> Về trang chủ
            </a>
        </div>
    </div>
</div>
</body>
</html>
