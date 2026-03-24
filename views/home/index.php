<?php
// Homepage view — receives: $categories, $featured, $flashSale, $newsLatest, $pageContent, $flashEndTime
?>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-text" data-aos>
            <div class="hero-badge">🛍️ Hơn 50 triệu sản phẩm</div>
            <h1 class="hero-headline">Mua sắm thông minh<br><span>Giá tốt mỗi ngày</span></h1>
            <p class="hero-sub">Khám phá hàng ngàn sản phẩm chất lượng với mức giá ưu đãi nhất từ các nhà bán hàng uy tín trên toàn quốc.</p>
            <div class="hero-ctas">
                <a href="<?= url('products') ?>" class="btn btn-primary btn-lg ripple">
                    <span class="material-icons-round">bolt</span> Khám phá ngay
                </a>
                <a href="<?= url('seller') ?>" class="btn btn-outline btn-lg ripple">Đăng ký gian hàng</a>
            </div>
            <div class="hero-stats">
                <div class="stat"><strong>50M+</strong><span>Sản phẩm</span></div>
                <div class="stat-divider"></div>
                <div class="stat"><strong>2M+</strong><span>Người bán</span></div>
                <div class="stat-divider"></div>
                <div class="stat"><strong>24h</strong><span>Giao nhanh</span></div>
            </div>
        </div>
        <div class="hero-visual" data-aos>
            <div class="hero-illustration">
                <div class="blob"></div>
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBOJTO2CepE1xyhXQIXeQEtgzZAnqIDV619V1xwHI7uOHM7vfP43gvInaalCCJxXA17vRZ6bBj5W796LQwrSuuWnDzuq21xWu1u5Au1RLQ5NulGAEFVWJUjL8reMAzC51QNEWiPThkU4LdWcohQgGu6UPZUB7Mz_65M8ASnvUPIv_aafgEjH2z9FWEcJjSC2CVG-Y8USn0Kv68VPLrAaU6qFBvrRpZ0eJU6CCaYUZ7o7gR-oXDo2TOmcbHNMxoIB2D" alt="Shopping" class="shopping-svg">
                <div class="hero-float-badge float-badge-1"><span class="material-symbols-rounded">shopping_bag</span></div>
                <div class="hero-float-badge float-badge-2">🔥 -50%</div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 30C240 60 480 0 720 30C960 60 1200 0 1440 30V60H0V30Z" fill="var(--gray-50)"/></svg>
    </div>
</section>

<!-- CATEGORIES -->
<section class="section categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Danh mục nổi bật</h2>
            <a href="<?= url('products') ?>" class="see-all-link">Xem tất cả <span class="material-symbols-rounded">chevron_right</span></a>
        </div>
        <div class="categories-grid">
            <?php
            $catIcons = ['devices','styler','restaurant','menu_book','fitness_center','face_3','chair','toys','two_wheeler','category'];
            foreach ($categories as $i => $cat): 
                $icon = $catIcons[$i] ?? 'category';
            ?>
            <a href="<?= url('category/' . e($cat['slug'])) ?>" class="cat-card" data-aos>
                <div class="cat-icon-wrap">
                    <span class="material-symbols-rounded"><?= $icon ?></span>
                </div>
                <span class="cat-label"><?= e($cat['name']) ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FLASH SALE -->
<?php if ($flashSale): ?>
<section class="section flash-section">
    <div class="container">
        <div class="flash-header">
            <div class="flash-title-wrap">
                <h2 class="flash-title"><span class="material-symbols-rounded" style="font-size:28px;vertical-align:middle">bolt</span> Flash Sale</h2>
                <div class="countdown">
                    <div class="cd-block"><span id="cd-h">00</span><small>Giờ</small></div>
                    <span class="cd-sep">:</span>
                    <div class="cd-block"><span id="cd-m">00</span><small>Phút</small></div>
                    <span class="cd-sep">:</span>
                    <div class="cd-block"><span id="cd-s">00</span><small>Giây</small></div>
                </div>
            </div>
            <a href="<?= url('products') ?>" class="see-all-link">Xem tất cả <span class="material-symbols-rounded">chevron_right</span></a>
        </div>
        <div class="flash-scroll">
            <div class="flash-track" id="flash-track">
                <?php foreach ($flashSale as $prod): 
                    $price     = (float)($prod['sale_price'] ?? $prod['price']);
                    $origPrice = (float)$prod['price'];
                    $hasSale   = $prod['sale_price'] && $prod['sale_price'] < $origPrice;
                    $discount  = $hasSale ? round((1 - $price / $origPrice) * 100) : 0;
                ?>
                <div class="flash-card" data-aos>
                    <div class="flash-img-wrap">
                        <?php if ($prod['cover_image']): ?>
                        <img src="<?= asset(e($prod['cover_image'])) ?>" alt="<?= e($prod['name']) ?>" class="flash-img" loading="lazy">
                        <?php else: ?>
                        <div style="width:100%;height:100%;background:var(--gray-100);display:flex;align-items:center;justify-content:center"><span class="material-symbols-rounded" style="font-size:48px;color:var(--gray-400)">image</span></div>
                        <?php endif; ?>
                        <?php if ($discount > 0): ?>
                        <span class="disc-badge">-<?= $discount ?>%</span>
                        <?php endif; ?>
                    </div>
                    <div class="flash-info">
                        <p class="flash-name"><?= e($prod['name']) ?></p>
                        <div class="price-row">
                            <span class="price-new"><?= formatPrice($price) ?></span>
                            <?php if ($hasSale): ?>
                            <span class="price-old"><?= formatPrice($origPrice) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="sold-row">
                            <span class="sold-label">Đã bán <?= rand(20,90) ?>%</span>
                            <div class="progress-bar"><div class="progress-fill" style="width:<?= rand(20,90) ?>%"></div></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FEATURED SHOPS -->
<section class="section shops-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Gian hàng nổi bật</h2>
            <a href="#" class="see-all-link">Xem tất cả <span class="material-symbols-rounded">chevron_right</span></a>
        </div>
        <div class="shops-grid" id="shops-grid">
            <!-- Rendered by JS or from PHP data -->
        </div>
    </div>
</section>

<!-- RECOMMENDED / FEATURED PRODUCTS -->
<?php if ($featured): ?>
<section class="section recommended-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Gợi ý cho bạn</h2>
            <a href="<?= url('products') ?>" class="see-all-link">Xem tất cả <span class="material-symbols-rounded">chevron_right</span></a>
        </div>
        <div class="products-grid" id="rec-grid">
            <?php foreach ($featured as $prod): ?>
            <?php include __DIR__ . '/../partials/product-card.php'; ?>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center;margin-top:32px">
            <a href="<?= url('products') ?>" class="btn btn-outline btn-lg">Xem thêm <span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle">sunny</span></a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- MODAL (for JS flash cards if rendered by app.js) -->
<div class="modal-overlay" id="modal-overlay">
    <div class="modal">
        <button class="modal-close" id="modal-close"><span class="material-symbols-rounded">close</span></button>
        <div class="modal-body">
            <div class="modal-img-wrap">
                <img src="" alt="" class="modal-img" id="modal-img">
                <span class="modal-badge" id="modal-badge"></span>
            </div>
            <div class="modal-info">
                <h2 class="modal-title" id="modal-title"></h2>
                <div class="modal-prices">
                    <span class="price-new" id="modal-new-price"></span>
                    <span class="price-old" id="modal-old-price"></span>
                </div>
                <div class="modal-meta">
                    <span class="modal-rating" id="modal-rating"></span>
                    <span class="modal-sold" id="modal-sold"></span>
                </div>
                <div class="modal-progress-wrap">
                    <div class="modal-prog-label">
                        <span>Đã bán</span>
                        <span id="modal-sold-pct">0%</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill" id="modal-prog-fill" style="width:0"></div></div>
                </div>
                <p class="modal-desc" id="modal-desc"></p>
                <div class="modal-actions">
                    <button class="btn btn-primary" id="modal-add-cart"><span class="material-symbols-rounded" style="font-size:20px">shopping_cart</span> Thêm vào giỏ</button>
                    <button class="btn btn-outline" id="modal-wishlist"><span class="material-symbols-rounded" style="font-size:20px">favorite_border</span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast">
    <span class="material-symbols-rounded">check_circle</span>
    <span id="toast-msg"></span>
</div>
