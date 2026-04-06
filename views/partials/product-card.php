<?php
// Partial: product card — expects $prod array
$price     = (float)($prod['sale_price'] ?? $prod['price']);
$origPrice = (float)$prod['price'];
$hasSale   = $prod['sale_price'] && $prod['sale_price'] < $origPrice;
$discount  = $hasSale ? round((1 - $price / $origPrice) * 100) : 0;
?>
<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative product-card-hover" data-aos="fade-up">
    <?php if ($hasSale): ?>
    <span class="position-absolute top-0 start-0 m-2 badge bg-danger text-white rounded-pill px-2 py-1 z-1">-<?= $discount ?>%</span>
    <?php endif; ?>
    <a href="<?= url('product/' . e($prod['slug'])) ?>" class="d-block position-relative ratio ratio-1x1 bg-light">
        <?php if ($prod['cover_image']): ?>
        <img src="<?= asset(e($prod['cover_image'])) ?>" alt="<?= e($prod['name']) ?>" class="object-fit-cover w-100 h-100" loading="lazy">
        <?php else: ?>
        <div class="d-flex align-items-center justify-content-center w-100 h-100">
            <span class="material-symbols-rounded text-secondary" style="font-size: 48px;">image</span>
        </div>
        <?php endif; ?>
    </a>
    <div class="card-body d-flex flex-column p-3">
        <h6 class="card-title mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
            <a href="<?= url('product/' . e($prod['slug'])) ?>" class="text-decoration-none text-dark fw-medium stretched-link"><?= e($prod['name']) ?></a>
        </h6>
        <div class="mt-auto">
            <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                <span class="fw-bold text-danger fs-5 lh-1"><?= formatPrice($price) ?></span>
                <?php if ($hasSale): ?>
                <span class="text-decoration-line-through text-muted small lh-1"><?= formatPrice($origPrice) ?></span>
                <?php endif; ?>
            </div>
            <div class="d-flex align-items-center small">
                <span class="text-warning lh-1">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </span>
                <span class="text-muted ms-1 lh-1">(<?= rand(10, 500) ?>)</span>
            </div>
        </div>
    </div>
</div>
