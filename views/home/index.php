<?php
// Homepage view — receives: $categories, $featured, $flashSale, $newsLatest, $pageContent, $flashEndTime
?>

<!-- HERO Section matching Stitch Design -->
<section class="position-relative overflow-hidden py-5 mb-5 shadow-sm" style="background: linear-gradient(135deg, #e0fff5 0%, #f0fff9 50%, #ffffff 100%); min-height: 70vh; display: flex; align-items: center;">
    <!-- Abstract shape similar to Stitch -->
    <div class="position-absolute h-100 bg-primary bg-opacity-10 d-none d-lg-block z-0" style="width: 60%; right: 0; top: 0; border-top-left-radius: 100px; border-bottom-left-radius: 100px; transform: skewX(-12deg) translateX(50px);"></div>
    
    <div class="container py-5 position-relative z-1">
        <div class="row align-items-center gap-y-5">
            <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start" data-aos="fade-right">
                <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-75 rounded-pill px-3 py-1 mb-4 fw-bold small shadow-sm text-uppercase tracking-wider border border-primary border-opacity-25" style="color: var(--text-sub); backdrop-filter: blur(8px);">
                    <span class="rounded-circle bg-primary" style="width: 8px; height: 8px; animation: opacityPulse 2s infinite;"></span>
                    Siêu Sale 9.9 Đang diễn ra
                </div>
                <style>
                @keyframes opacityPulse { 0% {opacity: 1;} 50% {opacity: 0.3;} 100% {opacity: 1;} }
                </style>
                <h1 class="display-3 fw-black mb-4 lh-sm text-dark font-playfair position-relative" style="font-weight: 900; letter-spacing: -1.5px;">
                    Mua sắm thông minh<br>
                    <span style="background: linear-gradient(90deg, #00c48c, #0c1d17); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Giá tốt mỗi ngày</span>
                </h1>
                <p class="lead mb-4 text-secondary mb-5" style="max-width: 480px; font-weight: 500;">Khám phá hàng ngàn sản phẩm chất lượng với mức giá ưu đãi nhất từ các nhà bán hàng uy tín trên toàn quốc.</p>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                    <a href="<?= url('products') ?>" class="btn btn-dark btn-lg rounded-4 px-5 py-3 fw-bold d-inline-flex align-items-center transition-all hover-transform group text-white shadow" style="font-size: 1.1rem;">
                        Khám phá ngay <span class="material-symbols-rounded ms-2 text-primary" style="transition: transform 0.3s;" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='none'">arrow_forward</span>
                    </a>
                    <a href="<?= url('seller') ?>" class="btn btn-outline-dark btn-lg rounded-4 px-5 py-3 fw-bold transition-all border-2" style="font-size: 1.1rem; background: transparent;">Đăng ký gian hàng</a>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start mt-5 gap-3">
                    <div class="d-flex position-relative">
                        <div class="rounded-circle bg-light border border-2 border-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; margin-left: -5px; z-index: 1;"><span class="material-symbols-rounded text-primary fs-5">face</span></div>
                        <div class="rounded-circle bg-light border border-2 border-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; margin-left: -15px; z-index: 2;"><span class="material-symbols-rounded text-success fs-5">face_3</span></div>
                        <div class="rounded-circle bg-light border border-2 border-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; margin-left: -15px; z-index: 3;"><span class="material-symbols-rounded text-info fs-5">face_4</span></div>
                        <div class="rounded-circle bg-gray-200 border border-2 border-white d-flex align-items-center justify-content-center shadow-sm text-dark fw-bold small" style="width: 40px; height: 40px; margin-left: -15px; z-index: 4; font-size: 0.75rem;">+2k</div>
                    </div>
                    <span class="small fw-medium text-secondary ms-2 text-dark">Người dùng mới hôm nay</span>
                </div>
            </div>
            <div class="col-lg-6 position-relative text-center d-none d-lg-flex justify-content-center min-h-400" data-aos="fade-left">
                <!-- Abstract visual representation matching Stitch -->
                <div class="position-relative" style="width: 400px; height: 500px;">
                    <!-- Phone frame mockup via CSS -->
                    <div class="position-absolute bg-white rounded-5 shadow-lg z-2" style="width: 260px; height: 460px; top: 20px; right: 0; transform: rotate(-5deg); transition: transform 0.5s; border: 8px solid #111;">
                        <div class="w-100 h-100 bg-light d-flex flex-column rounded-4 overflow-hidden">
                            <div class="bg-primary bg-opacity-25 w-100 mb-3" style="height: 60px;"></div>
                            <div class="px-3">
                                <div class="bg-gray-200 rounded-3 w-100 mb-3" style="height: 100px;"></div>
                                <div class="d-flex gap-2">
                                    <div class="bg-gray-200 rounded-3 w-50" style="height: 80px;"></div>
                                    <div class="bg-gray-200 rounded-3 w-50" style="height: 80px;"></div>
                                </div>
                            </div>
                            <div class="mt-auto bg-white border-top border-gray-200 d-flex justify-content-around align-items-center px-3" style="height: 60px;">
                                <div class="rounded-circle bg-primary bg-opacity-50" style="width: 30px; height: 30px;"></div>
                                <div class="rounded-circle bg-gray-200" style="width: 30px; height: 30px;"></div>
                                <div class="rounded-circle bg-gray-200" style="width: 30px; height: 30px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Big floating Shopping Bag background -->
                    <div class="position-absolute bg-primary rounded-5 shadow-lg z-1 d-flex align-items-center justify-content-center" style="width: 280px; height: 320px; top: 80px; left: 20px; transform: rotate(5deg);">
                        <span class="material-symbols-rounded text-dark text-opacity-25" style="font-size: 150px; transform: rotate(-5deg);">shopping_bag</span>
                    </div>
                    <!-- Floating badges -->
                    <div class="position-absolute bg-white p-3 rounded-4 shadow-lg z-3 animation-bounce" style="top: 0; left: 60px; animation: floatAnim 3s ease-in-out infinite;">
                        <span class="fs-4">🔥</span>
                    </div>
                    <div class="position-absolute bg-white px-3 py-2 rounded-4 shadow-lg z-3 text-success fw-bold fs-5" style="bottom: 80px; right: -20px; animation: floatAnim2 4s ease-in-out infinite;">
                        -50%
                    </div>
                    <style>
                        @keyframes floatAnim { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-10px);} }
                        @keyframes floatAnim2 { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-15px);} }
                    </style>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CATEGORIES -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h2 class="h3 fw-bold mb-0 text-dark">Danh mục nổi bật</h2>
            <a href="<?= url('products') ?>" class="text-decoration-none fw-bold d-flex align-items-center" style="color: var(--primary-dark);">Xem tất cả <span class="material-symbols-rounded fs-5 ms-1">chevron_right</span></a>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-10 g-3">
            <?php
            $catIcons = ['devices','styler','restaurant','menu_book','fitness_center','face_3','chair','toys','two_wheeler','category'];
            foreach ($categories as $i => $cat): 
                $icon = $catIcons[$i] ?? 'category';
            ?>
            <div class="col">
                <a href="<?= url('category/' . e($cat['slug'])) ?>" class="card h-100 border-0 text-decoration-none bg-transparent hover-bg-light text-center p-3 rounded-4 group transition-all" data-aos="fade-up">
                    <div class="card-body p-0 d-flex flex-column align-items-center justify-content-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 transition-all" style="width: 64px; height: 64px; background-color: #f0f9f6; transition: all 0.3s;" onmouseover="this.style.backgroundColor='var(--primary)'; this.style.transform='scale(1.1)';" onmouseout="this.style.backgroundColor='#f0f9f6'; this.style.transform='none';">
                            <span class="material-symbols-rounded fs-2 text-dark"><?= $icon ?></span>
                        </div>
                        <span class="text-secondary fw-bold small text-dark-hover" style="font-size: 0.8rem;"><?= e($cat['name']) ?></span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FLASH SALE -->
<?php if ($flashSale): ?>
<section class="py-5" style="background-color: #f8fcfb;">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div class="d-flex align-items-center flex-wrap gap-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-symbols-rounded fs-1 text-warning" style="font-variation-settings: 'FILL' 1;">bolt</span>
                    <h2 class="h3 fw-black mb-0 text-dark font-italic text-uppercase tracking-wider" style="font-weight: 900; letter-spacing: -1px;">Flash Sale</h2>
                </div>
                <div class="d-flex align-items-center gap-1 font-monospace text-white fw-bold">
                    <div class="bg-dark rounded px-2 py-1"><span id="cd-h" class="fs-6">02</span></div>
                    <span class="fs-5 fw-bold text-dark">:</span>
                    <div class="bg-dark rounded px-2 py-1"><span id="cd-m" class="fs-6">14</span></div>
                    <span class="fs-5 fw-bold text-dark">:</span>
                    <div class="bg-dark rounded px-2 py-1"><span id="cd-s" class="fs-6">35</span></div>
                </div>
            </div>
            <a href="<?= url('products') ?>" class="text-decoration-none fw-bold d-flex align-items-center" style="color: var(--primary-dark);">Xem tất cả <span class="material-symbols-rounded fs-5 ms-1">chevron_right</span></a>
        </div>
        
        <div class="overflow-auto pb-4 hide-scrollbar" style="scroll-snap-type: x mandatory; display: grid; grid-auto-columns: 200px; grid-auto-flow: column; gap: 1rem;">
            <?php foreach ($flashSale as $prod): 
                $price     = (float)($prod['sale_price'] ?? $prod['price']);
                $origPrice = (float)$prod['price'];
                $hasSale   = $prod['sale_price'] && $prod['sale_price'] < $origPrice;
                $discount  = $hasSale ? round((1 - $price / $origPrice) * 100) : 0;
            ?>
            <div class="card border border-light shadow-sm rounded-4 flex-shrink-0 bg-white hover-shadow transition-all group overflow-hidden" style="scroll-snap-align: start; min-width: 200px;" data-aos="fade-left">
                <div class="position-relative bg-light overflow-hidden ratio ratio-1x1">
                    <?php if ($prod['cover_image']): ?>
                    <img src="<?= asset(e($prod['cover_image'])) ?>" alt="<?= e($prod['name']) ?>" class="object-fit-cover w-100 h-100 transition-transform hover-scale" style="transition: transform 0.5s;" loading="lazy">
                    <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center w-100 h-100"><span class="material-symbols-rounded fs-1 text-secondary">image</span></div>
                    <?php endif; ?>
                    <?php if ($discount > 0): ?>
                    <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark rounded-2 z-1 fw-bold px-2 py-1 shadow-sm" style="font-size: 0.65rem;">-<?= $discount ?>%</span>
                    <?php endif; ?>
                </div>
                <div class="card-body p-3 d-flex flex-column bg-white">
                    <h3 class="fw-medium mb-2 text-dark line-clamp-2" style="font-size: 0.85rem; height: 40px;"><?= e($prod['name']) ?></h3>
                    <div class="mt-auto">
                        <div class="d-flex flex-column gap-1 mb-3">
                            <?php if ($hasSale): ?>
                            <span class="text-decoration-line-through text-muted lh-1" style="font-size: 0.75rem;"><?= formatPrice($origPrice) ?></span>
                            <?php else: ?>
                            <span class="lh-1" style="font-size: 0.75rem; visibility: hidden;">placeholder</span>
                            <?php endif; ?>
                            <span class="fw-bold text-danger fs-5 lh-1"><?= formatPrice($price) ?></span>
                        </div>
                        <div class="position-relative w-100 bg-gray-200 rounded-pill overflow-hidden" style="height: 16px;">
                            <div class="position-absolute top-0 start-0 h-100 w-<?= rand(25,90) ?>" style="background: linear-gradient(90deg, #FBBF24, #EF4444); width: <?= rand(40,90) ?>%;"></div>
                            <span class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center text-white fw-bold text-uppercase" style="font-size: 0.5rem; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">Đã bán <?= rand(20,90) ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FEATURED SHOPS -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="h3 fw-bold text-dark mb-4">Gian hàng nổi bật</h2>
        <div class="row g-4" id="shops-grid">
            <!-- Simulated Stitch Shop Cards -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-light shadow-sm rounded-4 p-4 bg-white hover-shadow transition-all">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle border border-gray-200 overflow-hidden flex-shrink-0" style="width: 64px; height: 64px;">
                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaRpOIIIGeKaaHMKdrmIknC0_fVbJi5yRb62bXycBlN5WKVWbdSYU5SbJwhlmgAMetbh5u-z7MTdOJriDO2jfaxcl9TpUa6qC3fScj_FdHhjQnQK25YNuTWmv0nnujBIPVmwAU5NqN7yCKcw47-OP8j6Xv7pufA0WZZx8cMlXFwJeSIsA0FX6a_UPAcxPJ3y79zCAVR4_3bzB5O2I7oHYb2MOyW1gU8Hd4bsDWDqZwRsTsFGJwEnzFnq6Jr1h4GgP0JJCJBJd0IE4" alt="Shop" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h3 class="fw-bold text-dark text-truncate mb-1" style="font-size: 1rem;">Thời Trang Official</h3>
                            <div class="d-flex align-items-center gap-1 text-sm text-warning mt-1" style="font-size: 0.8rem;">
                                <span class="material-symbols-rounded fill-current text-warning" style="font-size: 14px; font-variation-settings: 'FILL' 1;">star</span>
                                <span class="fw-medium text-secondary text-dark">4.9</span>
                                <span class="text-muted mx-1">|</span>
                                <span class="text-secondary text-muted">20k+ Follower</span>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-sm rounded-3 fw-bold px-3 py-2 text-nowrap" style="color: var(--primary-dark); border-color: var(--primary-dark);">Xem shop</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card border-light shadow-sm rounded-4 p-4 bg-white hover-shadow transition-all">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle border border-gray-200 overflow-hidden flex-shrink-0" style="width: 64px; height: 64px;">
                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuApKFzQ75BValwFHPApENtunG-0n97abSy_ZJRfaXKBdF_as0wHPKkrlJV2jXsNg2OmeIDk19r0M59TRB9Wzz9NEM3p1RMyM9n1m1L6pcYae3Ync70USfsa7qf4dW0WugrdAOH-pa4NFwGRioAHBVZ4SyA3-gM1IZ6yLMukVo0mKbvLrVU8-i0jktq72tO0D7iObOp5GNYtRyU5U3zqJXU5JLBijgdxrew-g27J5yKM5T25iJUsnHw2zK4EIy7NL3_D4ZxZDd07xiM" alt="Shop" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h3 class="fw-bold text-dark text-truncate mb-1" style="font-size: 1rem;">Tech Zone VN</h3>
                            <div class="d-flex align-items-center gap-1 text-warning mt-1" style="font-size: 0.8rem;">
                                <span class="material-symbols-rounded fill-current text-warning" style="font-size: 14px; font-variation-settings: 'FILL' 1;">star</span>
                                <span class="fw-medium text-secondary text-dark">4.8</span>
                                <span class="text-muted mx-1">|</span>
                                <span class="text-secondary text-muted">15k+ Follower</span>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-sm rounded-3 fw-bold px-3 py-2 text-nowrap" style="color: var(--primary-dark); border-color: var(--primary-dark);">Xem shop</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card border-light shadow-sm rounded-4 p-4 bg-white hover-shadow transition-all">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle border border-gray-200 overflow-hidden flex-shrink-0" style="width: 64px; height: 64px;">
                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCCFSf4Yuo8l8oTzZlWFK1AzYuxwVhRvlwbKgh4BZ2wLRYFo_9VleDx-ZgWmj2DSUFkwXGbTMmElpi8j5bjfA1bYgqLAVHlLFIJ5jVk1svHHXpziG5E1MzeuA3kdHkbGE-Ofjl_iQ6vM8iLl6U0Mn37L6hMdua2KzYTatSYvFK9skT68yCpepWvRXNwWLCfsJrQirG-zPyfThRmD4wsLdYIh4zD2ng7_m02LrIJsGJ5Do67S-GKj6T2q8QRNsRghKh1w69ANrXaL1I" alt="Shop" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h3 class="fw-bold text-dark text-truncate mb-1" style="font-size: 1rem;">Nhà Xinh Decor</h3>
                            <div class="d-flex align-items-center gap-1 text-warning mt-1" style="font-size: 0.8rem;">
                                <span class="material-symbols-rounded fill-current text-warning" style="font-size: 14px; font-variation-settings: 'FILL' 1;">star</span>
                                <span class="fw-medium text-secondary text-dark">5.0</span>
                                <span class="text-muted mx-1">|</span>
                                <span class="text-secondary text-muted">5k+ Follower</span>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-sm rounded-3 fw-bold px-3 py-2 text-nowrap" style="color: var(--primary-dark); border-color: var(--primary-dark);">Xem shop</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RECOMMENDED / FEATURED PRODUCTS -->
<?php if ($featured): ?>
<section class="py-5" style="background-color: #f8fcfb;">
    <div class="container">
        <div class="d-flex align-items-center gap-2 mb-4">
            <span class="material-symbols-rounded text-primary fs-3">thumb_up</span>
            <h2 class="h3 fw-bold text-dark mb-0">Gợi ý cho bạn</h2>
        </div>
        
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3 g-md-4" id="rec-grid">
            <?php foreach ($featured as $prod): ?>
            <div class="col">
                <?php include __DIR__ . '/../partials/product-card.php'; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5 mb-2">
            <a href="<?= url('products') ?>" class="btn btn-outline-dark bg-white border border-gray-200 btn-lg rounded-4 px-5 fw-bold shadow-sm d-inline-block hover-shadow transition-all" style="font-size: 0.9rem;">
                Xem thêm
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- MODAL (for JS flash cards if rendered by app.js) -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 position-absolute w-100 z-3 p-3">
                <button type="button" class="btn-close bg-white rounded-circle shadow-sm opacity-100" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row g-0">
                <div class="col-md-6 position-relative">
                    <img src="" alt="" class="img-fluid h-100 object-fit-cover w-100 bg-light" id="modal-img" style="min-height: 300px;">
                    <span class="position-absolute top-0 start-0 m-3 mt-4 mt-md-3 badge bg-danger text-white rounded-pill px-2 py-1 fs-6 z-1" id="modal-badge"></span>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="modal-body p-4 p-md-5 d-flex flex-column h-100 justify-content-center">
                        <h2 class="h4 fw-bold mb-3" id="modal-title"></h2>
                        <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                            <span class="fs-3 fw-bold text-danger lh-1" id="modal-new-price"></span>
                            <span class="text-decoration-line-through text-muted lh-1" id="modal-old-price"></span>
                        </div>
                        <div class="d-flex align-items-center small mb-4">
                            <span class="text-warning lh-1" id="modal-rating">★★★★★</span>
                            <span class="text-muted ms-2 lh-1" id="modal-sold"></span>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Đã bán</span>
                                <span id="modal-sold-pct">0%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger rounded-pill" id="modal-prog-fill" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                        <p class="text-muted small mb-4" id="modal-desc"></p>
                        <div class="d-flex gap-2 mt-auto">
                            <button class="btn btn-primary flex-grow-1 rounded-pill fw-medium d-flex align-items-center justify-content-center" id="modal-add-cart">
                                <span class="material-symbols-rounded me-2 fs-5">shopping_cart</span> Thêm vào giỏ
                            </button>
                            <button class="btn btn-outline-secondary rounded-pill px-3 d-flex align-items-center justify-content-center border-2 border" id="modal-wishlist">
                                <span class="material-symbols-rounded fs-5">favorite_border</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TOAST -->
<div class="toast-container position-fixed bottom-0 end-0 p-3 z-3">
    <div id="toast" class="toast align-items-center text-bg-success border-0 rounded-3 shadow" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center fw-medium py-3">
                <span class="material-symbols-rounded me-2">check_circle</span>
                <span id="toast-msg"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
