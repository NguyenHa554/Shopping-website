<?php
// Product detail view
// Expects: $product, $images, $reviews, $avgRating, $related, $userReview
$price     = (float)($product['sale_price'] ?? $product['price']);
$origPrice = (float)$product['price'];
$hasSale   = $product['sale_price'] && $price < $origPrice;
$discount  = $hasSale ? round((1 - $price / $origPrice) * 100) : 0;
$allImages = $images ?: ($product['cover_image'] ? [['image_path' => $product['cover_image']]] : []);
?>
<!-- Breadcrumb -->
<nav class="breadcrumb container">
    <a href="<?= url() ?>">Trang chủ</a><span>/</span>
    <a href="<?= url('products') ?>">Sản phẩm</a><span>/</span>
    <?php if (isset($product['category_slug'])): ?>
    <a href="<?= url('category/' . e($product['category_slug'])) ?>"><?= e($product['category_name'] ?? '') ?></a><span>/</span>
    <?php endif; ?>
    <span><?= e($product['name']) ?></span>
</nav>

<!-- Product Header -->
<section class="section product-detail-section">
    <div class="container product-detail-layout">

        <!-- Gallery -->
        <div class="product-gallery">
            <div class="gallery-main" id="galleryMain">
                <?php if ($allImages): ?>
                <img src="<?= asset(e($allImages[0]['image_path'] ?? $product['cover_image'])) ?>"
                     alt="<?= e($product['name']) ?>" id="mainImg">
                <?php else: ?>
                <div class="product-img-placeholder"><i class="fa fa-image"></i></div>
                <?php endif; ?>
            </div>
            <?php if (count($allImages) > 1): ?>
            <div class="gallery-thumbs" id="galleryThumbs">
                <?php foreach ($allImages as $i => $img): ?>
                <img src="<?= asset(e($img['image_path'])) ?>" alt="Ảnh <?= $i+1 ?>"
                     class="thumb <?= $i === 0 ? 'active' : '' ?>"
                     onclick="document.getElementById('mainImg').src=this.src; document.querySelectorAll('.thumb').forEach(t=>t.classList.remove('active')); this.classList.add('active');">
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Info -->
        <div class="product-info-panel">
            <div class="product-meta">
                <span class="product-category-tag"><?= e($product['category_name'] ?? '') ?></span>
                <?php if ($product['stock'] <= 0): ?>
                <span class="badge badge-sold-out">Hết hàng</span>
                <?php elseif ($product['stock'] <= 10): ?>
                <span class="badge badge-low-stock">Còn <?= (int)$product['stock'] ?> sản phẩm</span>
                <?php endif; ?>
            </div>
            <h1 class="product-title"><?= e($product['name']) ?></h1>
            <!-- Rating summary -->
            <div class="product-rating">
                <?php for ($s = 1; $s <= 5; $s++): ?>
                <i class="fa fa-star <?= $s <= round($avgRating) ? 'filled' : '' ?>"></i>
                <?php endfor; ?>
                <span class="rating-num"><?= $avgRating > 0 ? $avgRating : 'Chưa có đánh giá' ?></span>
                <span class="review-count">(<?= count($reviews) ?> đánh giá)</span>
            </div>
            <!-- Price -->
            <div class="product-price-block">
                <span class="price-big"><?= formatPrice($price) ?></span>
                <?php if ($hasSale): ?>
                <span class="price-orig"><?= formatPrice($origPrice) ?></span>
                <span class="price-badge">-<?= $discount ?>%</span>
                <?php endif; ?>
            </div>
            <!-- Description excerpt -->
            <div class="product-description">
                <p><?= truncate($product['description'] ?? '', 200) ?></p>
            </div>
            <!-- Add to cart -->
            <div class="add-to-cart-block">
                <div class="qty-control">
                    <button type="button" class="qty-btn" id="qtyMinus"><i class="fa fa-minus"></i></button>
                    <input type="number" id="qtyInput" value="1" min="1" max="<?= max(1,(int)$product['stock']) ?>" class="qty-input">
                    <button type="button" class="qty-btn" id="qtyPlus"><i class="fa fa-plus"></i></button>
                </div>
                <button class="btn btn-primary btn-lg btn-add-cart-detail"
                        data-id="<?= (int)$product['id'] ?>"
                        <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                    <i class="fa fa-cart-plus"></i>
                    <?= $product['stock'] <= 0 ? 'Hết hàng' : 'Thêm vào giỏ' ?>
                </button>
            </div>
            <!-- Promises -->
            <div class="product-promises">
                <span><i class="fa fa-truck"></i> Miễn phí ship từ 500K</span>
                <span><i class="fa fa-undo"></i> Đổi trả 30 ngày</span>
                <span><i class="fa fa-shield-alt"></i> Hàng chính hãng</span>
            </div>
        </div>
    </div>
</section>

<!-- Tab: Description & Reviews -->
<section class="section product-tabs-section">
    <div class="container">
        <div class="tabs" id="productTabs">
            <button class="tab-btn active" data-tab="desc">Mô tả sản phẩm</button>
            <button class="tab-btn" data-tab="reviews">Đánh giá (<?= count($reviews) ?>)</button>
        </div>

        <div class="tab-content active" id="tab-desc">
            <div class="product-full-description">
                <?= nl2br(e($product['description'] ?? 'Chưa có mô tả.')) ?>
            </div>
        </div>

        <div class="tab-content" id="tab-reviews">
            <!-- Review form (members only) -->
            <?php if (isLoggedIn()): ?>
            <form action="<?= url('review') ?>" method="POST" class="review-form" id="reviewForm">
                <?= csrfField() ?>
                <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                <h3><?= $userReview ? 'Cập nhật đánh giá của bạn' : 'Viết đánh giá' ?></h3>
                <div class="star-rating" id="starRating">
                    <?php for ($s = 5; $s >= 1; $s--): ?>
                    <input type="radio" id="star<?= $s ?>" name="rating" value="<?= $s ?>"
                           <?= ($userReview && (int)$userReview['rating'] === $s) ? 'checked' : ($s === 5 && !$userReview ? 'checked' : '') ?>>
                    <label for="star<?= $s ?>"><i class="fa fa-star"></i></label>
                    <?php endfor; ?>
                </div>
                <textarea name="comment" class="form-control" rows="4" placeholder="Nhận xét về sản phẩm..." required><?= e($userReview['comment'] ?? '') ?></textarea>
                <button type="submit" class="btn btn-primary">
                    <?= $userReview ? 'Cập nhật đánh giá' : 'Gửi đánh giá' ?>
                </button>
            </form>
            <?php else: ?>
            <div class="login-to-review">
                <p><a href="<?= url('login') ?>">Đăng nhập</a> để viết đánh giá.</p>
            </div>
            <?php endif; ?>

            <!-- Reviews list -->
            <?php if ($reviews): ?>
            <div class="reviews-list">
                <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <div class="reviewer">
                        <?php if ($review['avatar']): ?>
                        <img src="<?= asset(e($review['avatar'])) ?>" alt="<?= e($review['full_name']) ?>" class="reviewer-avatar">
                        <?php else: ?>
                        <div class="reviewer-avatar-placeholder"><i class="fa fa-user"></i></div>
                        <?php endif; ?>
                        <div>
                            <strong><?= e($review['full_name']) ?></strong>
                            <div class="review-stars">
                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                <i class="fa fa-star <?= $s <= (int)$review['rating'] ? 'filled' : '' ?>"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <time class="review-date"><?= formatDate($review['created_at']) ?></time>
                    </div>
                    <p class="review-comment"><?= nl2br(e($review['comment'] ?? '')) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="no-reviews">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá!</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Related -->
<?php if ($related): ?>
<section class="section related-section">
    <div class="container">
        <h2>Sản phẩm liên quan</h2>
        <div class="product-grid">
            <?php foreach ($related as $prod): ?>
            <?php include ROOT_PATH . '/views/partials/product-card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
// Tabs
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
    });
});
// Qty
const qtyInput = document.getElementById('qtyInput');
document.getElementById('qtyMinus')?.addEventListener('click', () => qtyInput.value = Math.max(1, +qtyInput.value - 1));
document.getElementById('qtyPlus')?.addEventListener('click' , () => qtyInput.value = Math.min(+qtyInput.max, +qtyInput.value + 1));
// Add to cart (detail page)
document.querySelector('.btn-add-cart-detail')?.addEventListener('click', function() {
    if (!IS_LOGGED_IN) { window.location.href = BASE_URL + '/login'; return; }
    const qty = +qtyInput.value;
    fetch(BASE_URL + '/cart/add', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: `product_id=${this.dataset.id}&quantity=${qty}&csrf_token=${CSRF_TOKEN}`
    }).then(r => r.json()).then(d => {
        if (d.count !== undefined) document.getElementById('cartCount').textContent = d.count;
        showToast('Đã thêm vào giỏ hàng!', 'success');
    }).catch(() => showToast('Có lỗi xảy ra.', 'error'));
});
</script>
