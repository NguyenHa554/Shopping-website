<?php
// Product detail view
// Expects: $product, $images, $reviews, $avgRating, $related, $userReview
$price     = (float)($product['sale_price'] ?? $product['price']);
$origPrice = (float)$product['price'];
$hasSale   = $product['sale_price'] && $price < $origPrice;
$discount  = $hasSale ? round((1 - $price / $origPrice) * 100) : 0;
$allImages = $images ?: ($product['cover_image'] ? [['image_path' => $product['cover_image']]] : []);
?>
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= url() ?>" class="text-decoration-none hover-primary">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?= url('products') ?>" class="text-decoration-none hover-primary">Sản phẩm</a></li>
                <?php if (isset($product['category_slug'])): ?>
                <li class="breadcrumb-item"><a href="<?= url('category/' . e($product['category_slug'])) ?>" class="text-decoration-none hover-primary"><?= e($product['category_name'] ?? '') ?></a></li>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page"><?= e($product['name']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-4">
    <div class="container">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="row g-0">
                <!-- Gallery -->
                <div class="col-md-6 col-lg-5 p-4 py-lg-5 ps-lg-5 border-end bg-white">
                    <div class="position-relative bg-light rounded-3 overflow-hidden ratio ratio-1x1 mb-3" id="galleryMain">
                        <?php if ($allImages): ?>
                        <img src="<?= asset(e($allImages[0]['image_path'] ?? $product['cover_image'])) ?>"
                             alt="<?= e($product['name']) ?>" id="mainImg" class="object-fit-cover w-100 h-100">
                        <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center w-100 h-100 text-secondary">
                            <span class="material-symbols-rounded" style="font-size: 64px;">image</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if (count($allImages) > 1): ?>
                    <div class="d-flex gap-2 overflow-auto pb-2 hide-scrollbar ps-1" id="galleryThumbs">
                        <?php foreach ($allImages as $i => $img): ?>
                        <img src="<?= asset(e($img['image_path'])) ?>" alt="Ảnh <?= $i+1 ?>"
                             class="rounded cursor-pointer border <?= $i === 0 ? 'border-primary border-2' : '' ?>" style="width: 70px; height: 70px; max-width: 70px; flex-shrink:0; object-fit: cover; transition: all 0.2s;"
                             onclick="document.getElementById('mainImg').src=this.src; document.querySelectorAll('#galleryThumbs img').forEach(t=>{t.classList.remove('border-primary', 'border-2');}); this.classList.add('border-primary', 'border-2');">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Info -->
                <div class="col-md-6 col-lg-7 p-4 p-lg-5 bg-white d-flex flex-column">
                    <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge text-bg-primary fs-6 fw-normal px-3 py-2 rounded-pill"><?= e($product['category_name'] ?? '') ?></span>
                        <?php if ($product['stock'] <= 0): ?>
                        <span class="badge text-bg-danger fs-6 fw-normal px-3 py-2 rounded-pill">Hết hàng</span>
                        <?php elseif ($product['stock'] <= 10): ?>
                        <span class="badge text-bg-warning text-dark fs-6 fw-normal px-3 py-2 rounded-pill">Còn <?= (int)$product['stock'] ?> sản phẩm</span>
                        <?php endif; ?>
                    </div>
                    
                    <h1 class="h2 fw-bold mb-3 font-playfair lh-base"><?= e($product['name']) ?></h1>
                    
                    <!-- Rating summary -->
                    <div class="d-flex align-items-center mb-4 gap-2">
                        <div class="text-warning lh-1">
                            <?php for ($s = 1; $s <= 5; $s++): ?>
                            <i class="fas <?= $s <= round($avgRating) ? 'fa-star' : 'fa-star text-light' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="fw-medium text-dark"><?= $avgRating > 0 ? $avgRating : 'Chưa có đánh giá' ?></span>
                        <span class="text-muted border-start ps-2 ms-1">(<?= count($reviews) ?> đánh giá)</span>
                    </div>
                    
                    <!-- Price -->
                    <div class="p-3 bg-light rounded-4 mb-4 d-flex align-items-end flex-wrap gap-3 border">
                        <span class="display-5 fw-bold text-danger lh-1"><?= formatPrice($price) ?></span>
                        <?php if ($hasSale): ?>
                        <span class="fs-5 text-decoration-line-through text-muted lh-1 pb-1"><?= formatPrice($origPrice) ?></span>
                        <span class="badge bg-danger rounded-pill px-2 py-1 align-bottom mb-1">-<?= $discount ?>%</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Description excerpt -->
                    <p class="text-secondary mb-4 lh-lg"><?= truncate($product['description'] ?? '', 200) ?></p>
                    
                    <!-- Add to cart -->
                    <div class="d-flex flex-wrap gap-3 mt-auto pt-4 border-top">
                        <div class="input-group" style="width: 140px; height: 50px;">
                            <button class="btn btn-outline-secondary px-3 bg-light" type="button" id="qtyMinus"><i class="fas fa-minus"></i></button>
                            <input type="number" id="qtyInput" class="form-control text-center fw-medium border-secondary h-100" value="1" min="1" max="<?= max(1,(int)$product['stock']) ?>">
                            <button class="btn btn-outline-secondary px-3 bg-light" type="button" id="qtyPlus"><i class="fas fa-plus"></i></button>
                        </div>
                        <button class="btn btn-primary btn-lg flex-grow-1 btn-add-cart-detail rounded-pill d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                data-id="<?= (int)$product['id'] ?>"
                                <?= $product['stock'] <= 0 ? 'disabled' : '' ?> style="height: 50px;">
                            <span class="material-symbols-rounded me-2">shopping_cart</span>
                            <?= $product['stock'] <= 0 ? 'Hết hàng' : 'Thêm vào giỏ' ?>
                        </button>
                    </div>
                    
                    <!-- Promises -->
                    <div class="d-flex flex-wrap gap-4 mt-4 pt-4 border-top text-dark">
                        <div class="d-flex align-items-center small fw-medium">
                            <span class="material-symbols-rounded text-success me-2 fs-4">local_shipping</span> Miễn phí ship từ 500K
                        </div>
                        <div class="d-flex align-items-center small fw-medium">
                            <span class="material-symbols-rounded text-info me-2 fs-4">sync</span> Đổi trả 30 ngày
                        </div>
                        <div class="d-flex align-items-center small fw-medium">
                            <span class="material-symbols-rounded text-primary me-2 fs-4">verified</span> Hàng chính hãng
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab: Description & Reviews -->
        <div class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden">
            <div class="card-header bg-white border-bottom-0 p-0 px-md-4 pt-md-3">
                <ul class="nav nav-tabs nav-justified border-bottom-0" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold fs-5 border-0 border-bottom border-primary border-3 bg-transparent text-dark py-3 rounded-0" id="desc-tab" data-bs-toggle="tab" data-bs-target="#tab-desc" type="button" role="tab" aria-controls="tab-desc" aria-selected="true" onclick="document.querySelectorAll('#productTabs .nav-link').forEach(btn => btn.classList.remove('border-primary', 'border-3', 'text-dark', 'text-muted')); this.classList.add('border-primary', 'border-3', 'text-dark'); document.getElementById('reviews-tab').classList.add('text-muted');">Mô tả sản phẩm</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold fs-5 border-0 bg-transparent text-muted py-3 rounded-0" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#tab-reviews" type="button" role="tab" aria-controls="tab-reviews" aria-selected="false" onclick="document.querySelectorAll('#productTabs .nav-link').forEach(btn => btn.classList.remove('border-primary', 'border-3', 'text-dark', 'text-muted')); this.classList.add('border-primary', 'border-3', 'text-dark'); document.getElementById('desc-tab').classList.add('text-muted');">Đánh giá (<?= count($reviews) ?>)</button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4 p-lg-5 bg-white border-top">
                <div class="tab-content" id="productTabsContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="tab-desc" role="tabpanel" aria-labelledby="desc-tab">
                        <div class="lh-lg text-secondary fs-6">
                            <?= nl2br(e($product['description'] ?? 'Chưa có mô tả.')) ?>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="row g-5">
                            <div class="col-lg-4 order-lg-2">
                                <!-- Review form (members only) -->
                                <?php if (isLoggedIn()): ?>
                                <div class="bg-light p-4 rounded-4 shadow-sm border border-light">
                                    <h4 class="h5 fw-bold mb-4"><?= $userReview ? 'Cập nhật đánh giá của bạn' : 'Viết đánh giá' ?></h4>
                                    <form action="<?= url('review') ?>" method="POST" id="reviewForm">
                                        <?= csrfField() ?>
                                        <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                                        
                                        <div class="mb-3 d-flex flex-row-reverse justify-content-end align-items-center rating-stars-form gap-1">
                                            <?php for ($s = 5; $s >= 1; $s--): ?>
                                            <input type="radio" class="btn-check" id="star<?= $s ?>" name="rating" value="<?= $s ?>" autocomplete="off"
                                                   <?= ($userReview && (int)$userReview['rating'] === $s) ? 'checked' : ($s === 5 && !$userReview ? 'checked' : '') ?>>
                                            <label class="btn btn-outline-warning border-0 fs-3 p-0 lh-1" for="star<?= $s ?>"><i class="fas fa-star"></i></label>
                                            <?php endfor; ?>
                                        </div>
                                        <style>
                                        .rating-stars-form > input:checked ~ label, .rating-stars-form > label:hover, .rating-stars-form > label:hover ~ label { color: #ffc107 !important; }
                                        .rating-stars-form > label { color: #dee2e6 !important; cursor: pointer; transition: color 0.1s; }
                                        </style>
                                        
                                        <div class="mb-3">
                                            <textarea name="comment" class="form-control bg-white border-0 shadow-sm rounded-3" rows="4" placeholder="Nhận xét về sản phẩm..." required><?= e($userReview['comment'] ?? '') ?></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-medium py-2 shadow-sm">
                                            <?= $userReview ? 'Cập nhật đánh giá' : 'Gửi đánh giá' ?>
                                        </button>
                                    </form>
                                </div>
                                <?php else: ?>
                                <div class="bg-light p-4 rounded-4 shadow-sm text-center border">
                                    <span class="material-symbols-rounded fs-1 text-muted mb-2">lock</span>
                                    <p class="mb-3 text-muted">Đăng nhập để viết đánh giá cho sản phẩm này.</p>
                                    <a href="<?= url('login') ?>" class="btn btn-primary px-4 rounded-pill shadow-sm">Đăng nhập</a>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-lg-8 order-lg-1">
                                <!-- Reviews list -->
                                <?php if ($reviews): ?>
                                <div class="d-flex flex-column gap-4">
                                    <?php foreach ($reviews as $review): ?>
                                    <div class="d-flex gap-3">
                                        <div class="flex-shrink-0">
                                            <?php if ($review['avatar']): ?>
                                            <img src="<?= asset(e($review['avatar'])) ?>" alt="<?= e($review['full_name']) ?>" class="rounded-circle object-fit-cover shadow-sm border" width="50" height="50">
                                            <?php else: ?>
                                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary border shadow-sm" style="width: 50px; height: 50px;">
                                                <i class="fas fa-user fs-5"></i>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="bg-light p-3 p-md-4 rounded-4 rounded-top-start-0 border border-light shadow-sm">
                                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-1">
                                                    <strong class="fw-bold text-dark mb-1 d-block"><?= e($review['full_name']) ?></strong>
                                                    <span class="small text-muted flex-shrink-0"><i class="far fa-clock me-1"></i><?= formatDate($review['created_at']) ?></span>
                                                </div>
                                                <div class="text-warning small mb-3 lh-1">
                                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                                    <i class="fas <?= $s <= (int)$review['rating'] ? 'fa-star' : 'fa-star text-secondary text-opacity-25' ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                                <p class="mb-0 text-secondary fs-6"><?= nl2br(e($review['comment'] ?? '')) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-muted" style="width: 80px; height: 80px;">
                                        <span class="material-symbols-rounded fs-1">reviews</span>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">Chưa có đánh giá nào</h5>
                                    <p class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related -->
        <?php if ($related): ?>
        <div class="mb-5 border-top pt-5">
            <h3 class="fw-bold mb-4 d-flex align-items-center"><span class="material-symbols-rounded text-primary me-2 fs-2">category</span> Sản phẩm liên quan</h3>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3 g-md-4">
                <?php foreach ($related as $prod): ?>
                <div class="col">
                    <?php include ROOT_PATH . '/views/partials/product-card.php'; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
// Qty
const qtyInput = document.getElementById('qtyInput');
document.getElementById('qtyMinus')?.addEventListener('click', () => { qtyInput.value = Math.max(1, +qtyInput.value - 1); });
document.getElementById('qtyPlus')?.addEventListener('click' , () => { qtyInput.value = Math.min(+qtyInput.max, +qtyInput.value + 1); });

// Add to cart (detail page)
document.querySelector('.btn-add-cart-detail')?.addEventListener('click', function() {
    if (!IS_LOGGED_IN) { window.location.href = BASE_URL + '/login'; return; }
    const qty = +qtyInput.value;
    
    const origHtml = this.innerHTML;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Đang thêm...';
    
    fetch(BASE_URL + '/cart/add', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: `product_id=${this.dataset.id}&quantity=${qty}&csrf_token=${CSRF_TOKEN}`
    }).then(r => r.json()).then(d => {
        this.innerHTML = '<span class="material-symbols-rounded me-2">check</span> Đã thêm';
        this.classList.replace('btn-primary', 'btn-success');
        
        setTimeout(() => {
            this.innerHTML = origHtml;
            this.classList.replace('btn-success', 'btn-primary');
        }, 2000);
        
        if (d.count !== undefined) {
            const countEl = document.getElementById('cartCount');
            if(countEl) {
                countEl.textContent = d.count;
                countEl.classList.add('bg-warning');
                setTimeout(()=>countEl.classList.remove('bg-warning'), 500);
            }
        }
        
        const toastEl = document.getElementById('toast');
        if(toastEl) {
            const t = new bootstrap.Toast(toastEl);
            document.getElementById('toast-msg').textContent = 'Đã thêm vào giỏ hàng thành công!';
            t.show();
        }
    }).catch(() => {
        this.innerHTML = origHtml;
        const toastEl = document.getElementById('toast');
        if(toastEl) {
            const t = new bootstrap.Toast(toastEl);
            toastEl.classList.replace('text-bg-success', 'text-bg-danger');
            const icon = toastEl.querySelector('.material-symbols-rounded');
            if(icon) icon.textContent = 'error';
            document.getElementById('toast-msg').textContent = 'Có lỗi xảy ra.';
            t.show();
        }
    });
});
</script>
