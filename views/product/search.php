<?php
// Product search/list view
// Expects: $products, $categories, $pg, $keyword, $sort, $empty, $cat (optional)
$currentCat = $cat ?? null;
?>

<section class="page-hero">
    <div class="container">
        <h1><?= isset($currentCat) ? e($currentCat['name']) : (isset($keyword) && $keyword ? 'Kết quả: "' . e($keyword) . '"' : 'Tất cả sản phẩm') ?></h1>
        <nav class="breadcrumb">
            <a href="<?= url() ?>">Trang chủ</a>
            <span>/</span>
            <?php if (isset($currentCat)): ?>
            <a href="<?= url('products') ?>">Sản phẩm</a><span>/</span>
            <span><?= e($currentCat['name']) ?></span>
            <?php elseif (isset($keyword) && $keyword): ?>
            <span>Tìm kiếm</span>
            <?php else: ?>
            <span>Sản phẩm</span>
            <?php endif; ?>
        </nav>
    </div>
</section>

<section class="section shop-section">
    <div class="container">

        <!-- TOP INFO + SORT BAR -->
        <div class="search-info-bar">
            <div class="search-result-text">
                <?php if (isset($keyword) && $keyword): ?>
                Kết quả tìm kiếm cho: <strong>"<?= e($keyword) ?>"</strong>
                <?php endif; ?>
                <span class="result-count"><?= ($pg['total'] ?? 0) ?> sản phẩm</span>
            </div>
            <div class="sort-bar">
                <span class="sort-label">Sắp xếp:</span>
                <?php
                $sorts = ['newest' => 'Mới nhất', 'price_asc' => 'Giá tăng dần', 'price_desc' => 'Giá giảm dần', 'bestseller' => 'Bán chạy'];
                $curSort = $sort ?? 'newest';
                $baseRoute = (isset($keyword) && $keyword) ? 'search' : 'products';
                foreach ($sorts as $val => $label):
                    $q = http_build_query(array_filter(['q' => $keyword ?? '', 'cat' => $currentCat['slug'] ?? '', 'sort' => $val]));
                ?>
                <a href="<?= url($baseRoute . '?' . $q) ?>"
                   class="sort-btn <?= $curSort === $val ? 'active' : '' ?>"><?= $label ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="search-layout">

            <!-- FILTER SIDEBAR -->
            <aside class="filter-sidebar shop-sidebar" id="filter-sidebar">
                <form action="<?= url($baseRoute) ?>" method="GET" id="filterForm">
                    <?php if (isset($keyword) && $keyword): ?>
                    <input type="hidden" name="q" value="<?= e($keyword) ?>">
                    <?php endif; ?>

                    <div class="filter-card">
                        <div class="filter-header">
                            <h3><span class="material-icons-round">tune</span> Bộ lọc tìm kiếm</h3>
                            <a href="<?= url($baseRoute . (isset($keyword) && $keyword ? '?q=' . urlencode($keyword) : '')) ?>"
                               class="filter-clear-btn">Xóa lọc</a>
                        </div>

                        <!-- Categories -->
                        <div class="filter-group sidebar-block">
                            <div class="filter-group-title">Danh mục</div>
                            <ul class="cat-list">
                                <li><a href="<?= url('products') ?>" class="<?= !$currentCat && !(($keyword ?? '')) ? 'active' : '' ?>">Tất cả</a></li>
                                <?php foreach ($categories as $c): ?>
                                <li>
                                    <a href="<?= url('category/' . e($c['slug'])) ?>"
                                       class="<?= ($currentCat && $currentCat['id'] == $c['id']) ? 'active' : '' ?>">
                                        <?= e($c['name']) ?> <span class="count">(<?= (int)$c['product_count'] ?>)</span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Price range -->
                        <div class="filter-group">
                            <div class="filter-group-title">Khoảng giá (₫)</div>
                            <div class="price-range-inputs">
                                <input type="number" name="price_min" class="price-input" placeholder="Từ"
                                       id="price-min" value="<?= e($_GET['price_min'] ?? '') ?>">
                                <span class="price-range-sep">–</span>
                                <input type="number" name="price_max" class="price-input" placeholder="Đến"
                                       id="price-max" value="<?= e($_GET['price_max'] ?? '') ?>">
                            </div>
                            <button type="submit" class="btn btn-outline btn-sm" style="width:100%;margin-top:10px">Áp dụng giá</button>
                        </div>

                        <!-- Rating -->
                        <div class="filter-group">
                            <div class="filter-group-title">Đánh giá</div>
                            <?php foreach ([5,4,3] as $stars): ?>
                            <label class="filter-check">
                                <input type="radio" name="rating" value="<?= $stars ?>"
                                       <?= (($_GET['rating'] ?? '') == $stars) ? 'checked' : '' ?>>
                                <?= str_repeat('★', $stars) . str_repeat('☆', 5 - $stars) ?>
                                <?= $stars < 5 ? ' trở lên' : '' ?>
                            </label>
                            <?php endforeach; ?>
                        </div>

                        <!-- Shipping -->
                        <div class="filter-group">
                            <div class="filter-group-title">Vận chuyển</div>
                            <label class="filter-check">
                                <input type="checkbox" name="freeship" value="1"
                                       <?= isset($_GET['freeship']) ? 'checked' : '' ?>>
                                <span class="text-success">🚀 Freeship</span>
                            </label>
                            <label class="filter-check">
                                <input type="checkbox" name="fast_delivery" value="1"
                                       <?= isset($_GET['fast_delivery']) ? 'checked' : '' ?>>
                                ⚡ Giao nhanh 2H
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                            <span class="material-icons-round">check</span> Áp dụng bộ lọc
                        </button>
                    </div>
                </form>
            </aside>

            <!-- PRODUCTS -->
            <div class="shop-main search-results-col">
                <?php if ($empty ?? false): ?>
                <div class="search-empty">
                    <div class="empty-illustration">
                        <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" width="140">
                            <circle cx="85" cy="85" r="55" stroke="#E0E0E0" stroke-width="8" fill="#F5F5F5"/>
                            <line x1="128" y1="128" x2="165" y2="165" stroke="#BDBDBD" stroke-width="10" stroke-linecap="round"/>
                            <text x="62" y="92" font-size="28" fill="#BDBDBD">?</text>
                        </svg>
                    </div>
                    <h2 class="empty-title">Không tìm thấy sản phẩm phù hợp</h2>
                    <p class="empty-sub">Hãy thử từ khoá khác hoặc xem toàn bộ sản phẩm.</p>
                    <a href="<?= url('products') ?>" class="btn btn-primary">Xem tất cả sản phẩm</a>
                </div>
                <?php else: ?>
                <div class="products-grid search-grid">
                    <?php foreach ($products as $prod): ?>
                    <?php include ROOT_PATH . '/views/partials/product-card.php'; ?>
                    <?php endforeach; ?>
                </div>
                <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Mobile filter FAB -->
<button class="mobile-filter-btn" id="mobile-filter-btn" aria-label="Bộ lọc">
    <span class="material-icons-round">tune</span> Bộ lọc & Sắp xếp
</button>

<script>
// Mobile filter toggle
document.getElementById('mobile-filter-btn')?.addEventListener('click', () => {
    document.getElementById('filter-sidebar')?.classList.toggle('open');
});
</script>
