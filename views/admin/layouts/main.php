<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Admin – SONNE') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Srtdash CSS (CDN) -->
    <link rel="stylesheet" href="https://colorlib.com/polygon/srtdash/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/admin/admin.css">
</head>
<body class="admin-body">
<?php $flash = flash(); ?>
<!-- Sidebar -->
<nav class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <a href="<?= BASE_URL ?>/admin/dashboard">SONNE<span>Admin</span></a>
        <button class="sidebar-close" id="sidebarClose"><i class="fa fa-times"></i></button>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-label">Dashboard</li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/dashboard') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/dashboard"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="menu-label">Nội dung</li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/products') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/products"><i class="fa fa-box"></i> Sản phẩm</a>
        </li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/categories') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/categories"><i class="fa fa-tags"></i> Danh mục</a>
        </li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/news') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/news"><i class="fa fa-newspaper"></i> Tin tức</a>
        </li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/pages') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/pages"><i class="fa fa-file-alt"></i> Nội dung trang</a>
        </li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/faq') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/faq"><i class="fa fa-question-circle"></i> FAQ</a>
        </li>
        <li class="menu-label">Kinh doanh</li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/orders') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/orders"><i class="fa fa-shopping-cart"></i> Đơn hàng</a>
        </li>
        <li class="menu-label">Người dùng</li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/users') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/users"><i class="fa fa-users"></i> Thành viên</a>
        </li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/reviews') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/reviews"><i class="fa fa-star"></i> Đánh giá</a>
        </li>
        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/contacts') ? 'class="active"' : '' ?>>
            <a href="<?= BASE_URL ?>/admin/contacts">
                <i class="fa fa-envelope"></i> Liên hệ
                <?php $unread = DB::count("SELECT COUNT(*) FROM contacts WHERE status='unread'"); ?>
                <?php if ($unread > 0): ?><span class="badge-pill"><?= $unread ?></span><?php endif; ?>
            </a>
        </li>
    </ul>
</nav>

<!-- Top bar -->
<header class="admin-topbar" id="adminTopbar">
    <button class="sidebar-toggle" id="sidebarToggle"><i class="fa fa-bars"></i></button>
    <div class="topbar-left">
        <a href="<?= BASE_URL ?>/" target="_blank" class="btn btn-sm btn-ghost">
            <i class="fa fa-external-link-alt"></i> Xem website
        </a>
    </div>
    <div class="topbar-right">
        <span class="admin-user">
            <i class="fa fa-user-circle"></i>
            <?= e($_SESSION['user']['full_name'] ?? 'Admin') ?>
        </span>
        <a href="<?= BASE_URL ?>/admin/logout" class="btn btn-sm btn-danger">
            <i class="fa fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>
</header>

<!-- Main content -->
<div class="admin-main" id="adminMain">
    <?php if ($flash): ?>
    <div class="flash-banner flash-<?= e($flash['type']) ?>">
        <?= e($flash['message']) ?>
        <button onclick="this.parentElement.remove()"><i class="fa fa-times"></i></button>
    </div>
    <?php endif; ?>

    <?= $content ?>
</div>

<script>
const BASE_URL = '<?= BASE_URL ?>';
const CSRF_TOKEN = '<?= e($_SESSION['csrf_token'] ?? '') ?>';
// Sidebar toggle
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    document.getElementById('adminSidebar').classList.toggle('open');
    document.getElementById('adminMain').classList.toggle('sidebar-open');
});
document.getElementById('sidebarClose')?.addEventListener('click', () => {
    document.getElementById('adminSidebar').classList.remove('open');
});
</script>
<?php if (isset($extraJs)) echo $extraJs; ?>
</body>
</html>
