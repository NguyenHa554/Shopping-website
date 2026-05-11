<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title><?= e($title ?? 'Admin – SONNE') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        <?= file_exists(ROOT_PATH . '/assets/admin/admin.css') ? trim(file_get_contents(ROOT_PATH . '/assets/admin/admin.css')) : '' ?>
    </style>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/admin/admin.css">
</head>
<body>
<?php $flash = flash(); ?>
<a href="#main-content" class="skip-link">Skip to main content</a>

<!-- page container -->
<div class="page-container">

    <!-- sidebar -->
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="<?= BASE_URL ?>/admin/dashboard">
                    <span class="sonne-brand">SONNE <span class="sonne-brand-sub">Admin</span></span>
                </a>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="admin-nav" id="menu">

                        <!-- Dashboard -->
                        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/dashboard') ? 'class="active"' : '' ?>>
                            <a href="<?= BASE_URL ?>/admin/dashboard">
                                <i class="fa-solid fa-gauge fa-fw me-2"></i><span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Products & Categories -->
                        <li <?= (str_contains($_SERVER['REQUEST_URI']??'', '/admin/products') || str_contains($_SERVER['REQUEST_URI']??'', '/admin/categories')) ? 'class="active"' : '' ?>>
                            <a href="javascript:void(0)" aria-expanded="<?= (str_contains($_SERVER['REQUEST_URI']??'', '/admin/products') || str_contains($_SERVER['REQUEST_URI']??'', '/admin/categories')) ? 'true' : 'false' ?>">
                                <i class="fa-solid fa-box fa-fw me-2"></i><span>Sản phẩm</span>
                            </a>
                            <ul class="submenu">
                                <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/products') ? 'class="active"' : '' ?>>
                                    <a href="<?= BASE_URL ?>/admin/products">Danh sách sản phẩm</a>
                                </li>
                                <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/categories') ? 'class="active"' : '' ?>>
                                    <a href="<?= BASE_URL ?>/admin/categories">Danh mục</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Orders -->
                        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/orders') ? 'class="active"' : '' ?>>
                            <a href="<?= BASE_URL ?>/admin/orders">
                                <i class="fa-solid fa-cart-shopping fa-fw me-2"></i><span>Đơn hàng</span>
                            </a>
                        </li>

                        <!-- Carts -->
                        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/carts') ? 'class="active"' : '' ?>>
                            <a href="<?= BASE_URL ?>/admin/carts">
                                <i class="fa-solid fa-basket-shopping fa-fw me-2"></i><span>Gi&#7887; h&#224;ng</span>
                            </a>
                        </li>

                        <!-- News -->
                        <li <?= (str_contains($_SERVER['REQUEST_URI']??'', '/admin/news') || str_contains($_SERVER['REQUEST_URI']??'', '/admin/news-comments')) ? 'class="active"' : '' ?>>
                            <a href="<?= BASE_URL ?>/admin/news">
                                <i class="fa-solid fa-newspaper fa-fw me-2"></i><span>Tin tức</span>
                            </a>
                            <ul class="submenu">
                                <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/news') && !str_contains($_SERVER['REQUEST_URI']??'', '/admin/news-comments') ? 'class="active"' : '' ?>>
                                    <a href="<?= BASE_URL ?>/admin/news">Bài viết</a>
                                </li>
                                <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/news-comments') ? 'class="active"' : '' ?>>
                                    <a href="<?= BASE_URL ?>/admin/news-comments">Bình luận bài viết</a>
                                </li>
                            </ul>
                        </li>

                        <!-- FAQ -->
                        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/faq') ? 'class="active"' : '' ?>>
                            <a href="<?= BASE_URL ?>/admin/faq">
                                <i class="fa-solid fa-circle-question fa-fw me-2"></i><span>FAQ</span>
                            </a>
                        </li>

                        <!-- Pages CMS -->
                        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/pages') ? 'class="active"' : '' ?>>
                            <a href="<?= BASE_URL ?>/admin/pages">
                                <i class="fa-solid fa-file-lines fa-fw me-2"></i><span>Nội dung trang</span>
                            </a>
                        </li>

                        <!-- Users -->
                        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/users') ? 'class="active"' : '' ?>>
                            <a href="<?= BASE_URL ?>/admin/users">
                                <i class="fa-solid fa-users fa-fw me-2"></i><span>Thành viên</span>
                            </a>
                        </li>

                        <!-- Reviews -->
                        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/reviews') ? 'class="active"' : '' ?>>
                            <a href="<?= BASE_URL ?>/admin/reviews">
                                <i class="fa-solid fa-star fa-fw me-2"></i><span>Đánh giá</span>
                            </a>
                        </li>

                        <!-- Contacts -->
                        <li <?= str_contains($_SERVER['REQUEST_URI']??'', '/admin/contacts') ? 'class="active"' : '' ?>>
                            <a href="<?= BASE_URL ?>/admin/contacts">
                                <i class="fa-solid fa-envelope fa-fw me-2"></i>
                                <span>Liên hệ</span>
                                <?php $unread = DB::count("SELECT COUNT(*) FROM contacts WHERE status='unread'"); ?>
                                <?php if ($unread > 0): ?>
                                    <span class="badge rounded-pill bg-danger ms-2" style="font-size:10px;"><?= $unread ?></span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <!-- Divider: Xem website -->
                        <li>
                            <a href="<?= BASE_URL ?>/" target="_blank">
                                <i class="fa-solid fa-house fa-fw me-2"></i><span>Xem website</span>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- sidebar end -->

    <!-- main content -->
    <div class="main-content">

        <!-- header -->
        <div class="header-area">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn float-start">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-4 clearfix">
                    <ul class="notification-area float-end">
                        <li id="full-view"><i class="fa-solid fa-expand"></i></li>
                        <li id="full-view-exit"><i class="fa-solid fa-compress"></i></li>
                        <li class="settings-btn"><i class="fa-solid fa-gear"></i></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- header end -->

        <!-- page title area -->
        <div class="page-title-area">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="breadcrumbs-area clearfix">
                        <h4 class="page-title float-start"><?= e($title ?? 'Dashboard') ?></h4>
                        <ul class="breadcrumbs float-start">
                            <li><a href="<?= BASE_URL ?>/admin/dashboard">Home</a></li>
                            <li><span><?= e($title ?? 'Dashboard') ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 clearfix">
                    <div class="user-profile float-end">
                        <i class="fa-solid fa-circle-user fa-2x" style="color:#6c63ff;"></i>
                        <h4 class="user-name dropdown-toggle" data-bs-toggle="dropdown">
                            <?= e($_SESSION['user']['full_name'] ?? 'Admin') ?>
                            <i class="fa-solid fa-angle-down"></i>
                        </h4>
                        <div class="dropdown-menu user-dropdown">
                            <a class="dropdown-item" href="<?= BASE_URL ?>/" target="_blank">
                                <i class="fa-solid fa-globe"></i> Xem website
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item user-dropdown-logout" href="<?= BASE_URL ?>/admin/logout">
                                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page title end -->

        <!-- main content inner -->
        <div class="main-content-inner" id="main-content">

            <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= e($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?= $content ?>

        </div>
        <!-- main content inner end -->

        <!-- footer -->
        <footer>
            <div class="footer-area">
                <p>© <?= date('Y') ?> <strong>SONNE</strong> Admin Panel. All rights reserved.</p>
            </div>
        </footer>
    </div>
    <!-- main content end -->

</div>
<!-- page container end -->

<!-- offset area (settings sidebar) -->
<div class="offset-area">
    <div class="offset-close"><i class="fa-solid fa-xmark"></i></div>
    <div class="offset-content tab-content">
        <div class="offset-settings">
            <h4>Thông tin admin</h4>
            <p class="text-muted"><?= e($_SESSION['user']['full_name'] ?? 'Admin') ?></p>
            <p class="text-muted"><?= e($_SESSION['user']['email'] ?? '') ?></p>
            <hr>
            <a href="<?= BASE_URL ?>/admin/logout" class="btn btn-danger btn-sm w-100">
                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const BASE_URL = '<?= BASE_URL ?>';
const CSRF_TOKEN = '<?= e($_SESSION['csrf_token'] ?? '') ?>';

document.querySelector('.nav-btn')?.addEventListener('click', () => {
    document.body.classList.toggle('sidebar-collapsed');
});

document.querySelector('.settings-btn')?.addEventListener('click', () => {
    document.body.classList.toggle('settings-open');
});

document.querySelector('.offset-close')?.addEventListener('click', () => {
    document.body.classList.remove('settings-open');
});
</script>
<?php if (isset($extraJs)) echo $extraJs; ?>
</body>
</html>
