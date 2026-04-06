<?php
// Admin Login view — standalone page (no sidebar)
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng nhập – SONNE Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../srtdash-admin-dashboard-master/srtdash/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../srtdash-admin-dashboard-master/srtdash/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../srtdash-admin-dashboard-master/srtdash/assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../srtdash-admin-dashboard-master/srtdash/assets/css/typography.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../srtdash-admin-dashboard-master/srtdash/assets/css/default-css.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../srtdash-admin-dashboard-master/srtdash/assets/css/styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../srtdash-admin-dashboard-master/srtdash/assets/css/responsive.css">
</head>
<body>
<!-- preloader -->
<div id="preloader"><div class="loader"></div></div>

<!-- login area start -->
<div class="login-area">
    <div class="container">
        <div class="login-box ptb--100">
            <?php $flash = flash(); if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> mb-3" role="alert">
                <?= e($flash['message']) ?>
            </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/admin/login" method="POST">
                <?= csrfField() ?>
                <div class="login-form-head">
                    <h4>SONNE Admin</h4>
                    <p>Đăng nhập để quản lý hệ thống</p>
                </div>
                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="email">Địa chỉ Email</label>
                        <input type="email" id="email" name="email"
                               placeholder="admin@sonne.vn" required autocomplete="email">
                        <i class="ti-email"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="form-gp">
                        <label for="password">Mật khẩu</label>
                        <input type="password" id="password" name="password"
                               placeholder="••••••••" required>
                        <i class="ti-lock"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit">
                            Đăng nhập <i class="ti-arrow-right"></i>
                        </button>
                    </div>
                    <div class="form-footer text-center mt-4">
                        <a href="<?= BASE_URL ?>/" style="color:#999;font-size:.875rem;text-decoration:none;">
                            <i class="ti-arrow-left"></i> Về trang chủ
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- login area end -->

<script src="<?= BASE_URL ?>/../srtdash-admin-dashboard-master/srtdash/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/../srtdash-admin-dashboard-master/srtdash/assets/js/scripts.js"></script>
</body>
</html>
