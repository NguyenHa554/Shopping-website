<?php
// Partial: product card — expects $prod array
$price     = (float)($prod['sale_price'] ?? $prod['price']);
$origPrice = (float)$prod['price'];
$hasSale   = $prod['sale_price'] && $prod['sale_price'] < $origPrice;
$discount  = $hasSale ? round((1 - $price / $origPrice) * 100) : 0;
?>
<div class="product-card" data-aos>
    <?php if ($hasSale): ?>
    <span class="disc-badge">-<?= $discount ?>%</span>
    <?php endif; ?>
    <a href="<?= url('product/' . e($prod['slug'])) ?>" class="prod-img-wrap">
        <?php if ($prod['cover_image']): ?>
        <img src="<?= asset(e($prod['cover_image'])) ?>" alt="<?= e($prod['name']) ?>" class="prod-img" loading="lazy">
        <?php else: ?>
        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--gray-100)"><span class="material-symbols-rounded" style="font-size:48px;color:var(--gray-400)">image</span></div>
        <?php endif; ?>
    </a>
    <div class="prod-info">
        <p class="prod-name">
            <a href="<?= url('product/' . e($prod['slug'])) ?>"><?= e($prod['name']) ?></a>
        </p>
        <div class="prod-price-row">
            <span class="prod-price"><?= formatPrice($price) ?></span>
            <?php if ($hasSale): ?>
            <span class="price-old"><?= formatPrice($origPrice) ?></span>
            <?php endif; ?>
        </div>
        <div class="prod-rating">
            <span>★★★★★</span>
            <span style="color:var(--gray-400)">(<?= rand(10, 500) ?>)</span>
        </div>
    </div>
</div>
