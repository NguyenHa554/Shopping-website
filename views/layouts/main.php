<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?></title>
    <meta name="description" content="<?= e($metaDescription ?? 'SONNE – Premium Beauty & Skincare') ?>">
    <link rel="icon" href="<?= asset('assets/images/favicon.ico') ?>">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Material Icons Round (for HTML prototype compatibility) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <?php if (isset($extraCss)) echo $extraCss; ?>
</head>
<body>
<!-- FLASH MESSAGE -->
<?php $flash = flash(); if ($flash): ?>
<div class="flash-banner flash-<?= e($flash['type']) ?>" id="flashBanner">
    <span><?= e($flash['message']) ?></span>
    <button onclick="this.parentElement.remove()"><i class="fa fa-times"></i></button>
</div>
<?php endif; ?>

<!-- HEADER -->
<header class="site-header" id="siteHeader">
    <div class="header-inner">
        <a href="<?= url() ?>" class="logo"><span class="material-symbols-rounded logo-icon">sunny</span> SONNE</a>

        <div class="header-search-wrap">
            <form action="<?= url('search') ?>" method="GET" class="header-search">
                <span class="material-symbols-rounded search-icon">search</span>
                <input type="search" name="q" class="search-input" placeholder="Tìm kiếm sản phẩm..." 
                       value="<?= e($_GET['q'] ?? '') ?>" aria-label="Tìm kiếm" id="main-search">
                <button type="submit" class="search-btn">Tìm kiếm</button>
            </form>
            <div class="sale-tag"><span class="material-symbols-rounded" style="font-size:16px">bolt</span> Siêu Sale 9.9 Đang diễn ra</div>
        </div>

        <div class="header-actions">
            <a href="<?= url('seller') ?>" class="btn btn-outline seller-btn">Đăng ký bán hàng</a>
            <button class="icon-btn" aria-label="Thông báo">
                <span class="material-symbols-rounded">notifications</span>
            </button>
            <a href="<?= url('cart') ?>" class="icon-btn" aria-label="Giỏ hàng">
                <span class="material-symbols-rounded">shopping_cart</span>
                <span class="badge" id="cartCount">0</span>
            </a>
            <?php if (isLoggedIn()): ?>
            <div class="user-menu">
                <button class="avatar-btn" id="userMenuBtn">
                    <?php if (currentUser()['avatar']): ?>
                    <img src="<?= asset(e(currentUser()['avatar'])) ?>" alt="avatar" class="avatar-img">
                    <?php else: ?>
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5jMwIDVYp69Sumcwau6yFuygLDpN8nCT9XP2CmkE5jufpmg-UNjWAfZOv5FVUyUilee4bkbUW7y0PNRaIi7Nj2Pn0vp0IPAaDHJRwXwqM9ZoVuG5ZIqH16WNdrf89p48lkhP3z2pc_1QF0_rUpKd_4pinE267Ituut7oJqHS9DhtRlJzDYQ3_F9GAW4UZ_Eg-NsnUzpl_KMk28iVQnrpBE8qMIMSssGh68mcH7ZS07jTb53qArv3KfeK5j4puKVfdSzjWhmb7Mag" alt="avatar" class="avatar-img">
                    <?php endif; ?>
                </button>
                <ul class="user-dropdown" id="userDropdown">
                    <li><a href="<?= url('profile') ?>"><i class="fa fa-user"></i> Hồ sơ</a></li>
                    <li><a href="<?= url('orders') ?>"><i class="fa fa-box"></i> Đơn hàng</a></li>
                    <?php if (isAdmin()): ?>
                    <li><a href="<?= url('admin') ?>"><i class="fa fa-shield-alt"></i> Admin</a></li>
                    <?php endif; ?>
                    <li class="divider"></li>
                    <li><a href="<?= url('logout') ?>"><i class="fa fa-sign-out-alt"></i> Đăng xuất</a></li>
                </ul>
            </div>
            <?php else: ?>
            <a href="<?= url('login') ?>" class="avatar-btn">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5jMwIDVYp69Sumcwau6yFuygLDpN8nCT9XP2CmkE5jufpmg-UNjWAfZOv5FVUyUilee4bkbUW7y0PNRaIi7Nj2Pn0vp0IPAaDHJRwXwqM9ZoVuG5ZIqH16WNdrf89p48lkhP3z2pc_1QF0_rUpKd_4pinE267Ituut7oJqHS9DhtRlJzDYQ3_F9GAW4UZ_Eg-NsnUzpl_KMk28iVQnrpBE8qMIMSssGh68mcH7ZS07jTb53qArv3KfeK5j4puKVfdSzjWhmb7Mag" alt="avatar" class="avatar-img">
            </a>
            <?php endif; ?>

            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

<main id="main-content">
<?= $content ?>
</main>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand brand-col">
                <div class="footer-logo"><span class="material-symbols-rounded" style="font-size:24px;vertical-align:middle">sunny</span> SONNE</div>
                <p class="footer-desc">Nền tảng thương mại điện tử hàng đầu Việt Nam, mang đến trải nghiệm mua sắm thông minh và tiện lợi.</p>
            </div>
            <div class="footer-col">
                <h4 class="footer-heading">Về SONNE</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('about') ?>">Giới thiệu</a></li>
                    <li><a href="#">Tuyển dụng</a></li>
                    <li><a href="#">Điều khoản dịch vụ</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-heading">Hỗ trợ khách hàng</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('faq') ?>">Trung tâm trợ giúp</a></li>
                    <li><a href="<?= url('faq') ?>">Hướng dẫn mua hàng</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Vận chuyển</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-heading">Kết nối với chúng tôi</h4>
                <div class="social-links">
                    <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <p>&copy; <?= date('Y') ?> SONNE Corporation. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                    <a href="#">Sitemap</a>
                </div>
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
<script src="<?= asset('app.js') ?>"></script>
<script src="<?= asset('assets/js/sonne.js') ?>"></script>
<?php if (isset($extraJs)) echo $extraJs; ?>
</body>
</html>
