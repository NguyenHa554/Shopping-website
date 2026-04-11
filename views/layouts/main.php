<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?></title>
    <meta name="description" content="<?= e($metaDescription ?? 'SONNE – Premium Beauty & Skincare') ?>">
    <link rel="icon" href="<?= asset('frontend/assets/images/favicon.ico') ?>">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Material Icons & Symbols -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= asset('frontend/style.css') ?>">
    <?php if (isset($extraCss)) echo $extraCss; ?>
</head>
<body class="d-flex flex-column min-vh-100 bg-light bg-opacity-50">
<!-- FLASH MESSAGE -->
<?php $flash = flash(); if ($flash): ?>
<div class="container mt-3">
    <div class="alert alert-<?= e($flash['type'] === 'error' ? 'danger' : 'success') ?> alert-dismissible fade show shadow-sm" role="alert">
        <?= e($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php endif; ?>

<!-- HEADER -->
<header class="navbar navbar-expand-lg sticky-top bg-white border-bottom shadow-sm py-2">
    <div class="container-fluid px-3 px-md-4">
        <a href="<?= url() ?>" class="navbar-brand fw-bold text-dark fs-4">
            <span class="material-symbols-rounded text-warning me-1" style="vertical-align: middle;">sunny</span> SONNE
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <form action="<?= url('search') ?>" method="GET" class="d-flex mx-auto my-3 my-lg-0 w-100" style="max-width: 500px;">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><span class="material-symbols-rounded fs-5">search</span></span>
                    <input type="search" name="q" class="form-control bg-light border-start-0 shadow-none ps-0" placeholder="Tìm kiếm sản phẩm..." value="<?= e($_GET['q'] ?? '') ?>" id="main-search">
                    <button type="submit" class="btn btn-dark px-4 fw-medium">Tìm kiếm</button>
                </div>
            </form>

            <div class="d-flex align-items-center gap-3 ms-lg-3">
                <a href="<?= url('seller') ?>" class="btn btn-outline-dark fw-medium d-none d-xl-inline-block">Đăng ký bán hàng</a>
                <button class="btn btn-link text-dark p-0 border-0 position-relative" aria-label="Thông báo">
                    <span class="material-symbols-rounded fs-4">notifications</span>
                </button>
                <a href="<?= url('cart') ?>" class="btn btn-link text-dark p-0 border-0 position-relative" aria-label="Giỏ hàng">
                    <span class="material-symbols-rounded fs-4">shopping_cart</span>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount" style="font-size:0.65rem;">0</span>
                </a>
                <?php if (isLoggedIn()): ?>
                <div class="dropdown">
                    <button class="btn btn-link text-dark p-0 border-0 dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="userMenuBtn">
                        <?php if (currentUser()['avatar']): ?>
                        <img src="<?= asset(e(currentUser()['avatar'])) ?>" alt="avatar" class="rounded-circle" width="36" height="36" style="object-fit:cover;">
                        <?php else: ?>
                        <span class="rounded-circle bg-light border d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                            <span class="material-symbols-rounded text-secondary" style="font-size:20px;">person</span>
                        </span>
                        <?php endif; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item py-2" href="<?= url('profile') ?>"><i class="fa fa-user fa-fw text-muted me-2"></i> Hồ sơ</a></li>
                        <li><a class="dropdown-item py-2" href="<?= url('orders') ?>"><i class="fa fa-box fa-fw text-muted me-2"></i> Đơn hàng</a></li>
                        <?php if (isAdmin()): ?>
                        <li><a class="dropdown-item py-2" href="<?= url('admin') ?>"><i class="fa fa-shield-alt fa-fw text-muted me-2"></i> Admin</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="<?= url('logout') ?>"><i class="fa fa-sign-out-alt fa-fw me-2"></i> Đăng xuất</a></li>
                    </ul>
                </div>
                <?php else: ?>
                <a href="<?= url('login') ?>" class="btn btn-link text-dark p-0 border-0 rounded-circle bg-light border d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;" aria-label="Đăng nhập">
                    <span class="material-symbols-rounded text-secondary" style="font-size:20px;">person</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<main id="main-content" class="flex-grow-1">
<?= $content ?>
</main>

<!-- FOOTER -->
<footer class="bg-white border-top pt-5 pb-3 mt-auto">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4 pe-md-5">
                <div class="d-flex align-items-center mb-3">
                    <span class="material-symbols-rounded text-warning fs-3 me-2">sunny</span>
                    <span class="fs-4 fw-bold">SONNE</span>
                </div>
                <p class="text-muted small mb-0">Nền tảng thương mại điện tử hàng đầu Việt Nam, mang đến trải nghiệm mua sắm thông minh và tiện lợi.</p>
            </div>
            <div class="col-6 col-md-2">
                <h5 class="fs-6 fw-bold mb-3">Về SONNE</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="<?= url('about') ?>" class="text-decoration-none text-muted small hover-primary">Giới thiệu</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted small hover-primary">Tuyển dụng</a></li>
                    <li class="mb-2"><a href="<?= url('pricing') ?>" class="text-decoration-none text-muted small hover-primary">Bảng giá</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted small hover-primary">Bảo mật</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-2">
                <h5 class="fs-6 fw-bold mb-3">Hỗ trợ</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="<?= url('services') ?>" class="text-decoration-none text-muted small hover-primary">Dịch vụ</a></li>
                    <li class="mb-2"><a href="<?= url('faq') ?>" class="text-decoration-none text-muted small hover-primary">Trung tâm trợ giúp</a></li>
                    <li class="mb-2"><a href="<?= url('faq') ?>" class="text-decoration-none text-muted small hover-primary">Hướng dẫn mua</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted small hover-primary">Đổi trả</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted small hover-primary">Vận chuyển</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-4">
                <h5 class="fs-6 fw-bold mb-3">Kết nối với chúng tôi</h5>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-light rounded-circle shadow-sm border-0 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-facebook-f text-dark"></i></a>
                    <a href="#" class="btn btn-light rounded-circle shadow-sm border-0 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-instagram text-dark"></i></a>
                    <a href="#" class="btn btn-light rounded-circle shadow-sm border-0 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-tiktok text-dark"></i></a>
                    <a href="#" class="btn btn-light rounded-circle shadow-sm border-0 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-youtube text-dark"></i></a>
                </div>
            </div>
        </div>
        <hr class="text-muted opacity-25">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-2">
            <p class="text-muted small mb-0">&copy; <?= date('Y') ?> SONNE Corporation. All rights reserved.</p>
            <div class="d-flex gap-3 mt-3 mt-md-0">
                <a href="#" class="text-decoration-none text-muted small">Privacy</a>
                <a href="#" class="text-decoration-none text-muted small">Terms</a>
                <a href="#" class="text-decoration-none text-muted small">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script>
const BASE_URL = '<?= BASE_URL ?>';
const CSRF_TOKEN = '<?= e($_SESSION['csrf_token'] ?? '') ?>';
const IS_LOGGED_IN = <?= isLoggedIn() ? 'true' : 'false' ?>;
</script>
<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset('frontend/app.js') ?>"></script>
<script src="<?= asset('frontend/assets/js/sonne.js') ?>"></script>
<?php if (isset($extraJs)) echo $extraJs; ?>
</body>
</html>
