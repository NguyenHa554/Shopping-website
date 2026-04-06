<?php
// Product search/list view
// Expects: $products, $categories, $pg, $keyword, $sort, $empty, $cat (optional)
$currentCat = $cat ?? null;
?>

<div class="bg-light py-5 border-bottom mb-5">
    <div class="container text-center">
        <h1 class="display-5 fw-bold mb-3 font-playfair">
            <?= isset($currentCat) ? e($currentCat['name']) : (isset($keyword) && $keyword ? 'Kết quả: "' . e($keyword) . '"' : 'Tất cả sản phẩm') ?>
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= url() ?>" class="text-decoration-none text-muted hover-primary">Trang chủ</a></li>
                <?php if (isset($currentCat)): ?>
                <li class="breadcrumb-item"><a href="<?= url('products') ?>" class="text-decoration-none text-muted hover-primary">Sản phẩm</a></li>
                <li class="breadcrumb-item active text-dark fw-medium" aria-current="page"><?= e($currentCat['name']) ?></li>
                <?php elseif (isset($keyword) && $keyword): ?>
                <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">Tìm kiếm</li>
                <?php else: ?>
                <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">Sản phẩm</li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>

<section class="py-4">
    <div class="container">
        <!-- TOP INFO + SORT BAR -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom gap-3">
            <div class="text-muted fs-6">
                <?php if (isset($keyword) && $keyword): ?>
                Kết quả cho: <strong class="text-dark">"<?= e($keyword) ?>"</strong> <span class="mx-2">•</span> 
                <?php endif; ?>
                Hiển thị <span class="fw-bold text-dark"><?= ($pg['total'] ?? 0) ?></span> sản phẩm
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted text-nowrap d-none d-md-inline">Sắp xếp:</span>
                <div class="dropdown">
                    <?php
                    $sorts = ['newest' => 'Mới nhất', 'price_asc' => 'Giá tăng dần', 'price_desc' => 'Giá giảm dần', 'bestseller' => 'Bán chạy'];
                    $curSort = $sort ?? 'newest';
                    $baseRoute = (isset($keyword) && $keyword) ? 'search' : 'products';
                    ?>
                    <button class="btn btn-outline-secondary dropdown-toggle bg-white shadow-sm fw-medium d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-rounded fs-5">sort</span> <?= $sorts[$curSort] ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <?php foreach ($sorts as $val => $label): 
                            $q = http_build_query(array_filter(['q' => $keyword ?? '', 'cat' => $currentCat['slug'] ?? '', 'sort' => $val]));
                        ?>
                        <li><a class="dropdown-item py-2 <?= $curSort === $val ? 'active bg-primary text-white' : '' ?>" href="<?= url($baseRoute . '?' . $q) ?>"><?= $label ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- Mobile Filter Toggle -->
                <button class="btn btn-primary d-lg-none d-flex align-items-center gap-2 shadow-sm fw-medium" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar" aria-controls="filterSidebar">
                    <span class="material-symbols-rounded fs-5">tune</span> <span class="d-none d-sm-inline">Bộ lọc</span>
                </button>
            </div>
        </div>

        <div class="row g-4 g-lg-5">
            <!-- FILTER SIDEBAR -->
            <div class="col-lg-3">
                <div class="offcanvas-lg offcanvas-start border-end-0 bg-white" tabindex="-1" id="filterSidebar" aria-labelledby="filterSidebarLabel">
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title fw-bold font-playfair d-flex align-items-center gap-2" id="filterSidebarLabel"><span class="material-symbols-rounded text-primary">tune</span> Bộ lọc</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body flex-column p-4 p-lg-0">
                        <form action="<?= url($baseRoute) ?>" method="GET" id="filterForm" class="w-100">
                            <?php if (isset($keyword) && $keyword): ?>
                            <input type="hidden" name="q" value="<?= e($keyword) ?>">
                            <?php endif; ?>

                            <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex border-bottom pb-3">
                                <h3 class="fs-5 fw-bold mb-0 d-flex align-items-center gap-2"><span class="material-symbols-rounded text-primary fs-4">tune</span> Bộ lọc</h3>
                                <a href="<?= url($baseRoute . (isset($keyword) && $keyword ? '?q=' . urlencode($keyword) : '')) ?>"
                                   class="text-decoration-none small text-danger text-opacity-75 hover-opacity-100 fw-medium">Xóa lọc</a>
                            </div>

                            <!-- Categories -->
                            <div class="mb-4 pb-4 border-bottom">
                                <h5 class="fw-bold mb-3 fs-6 text-uppercase text-secondary tracking-wide">Danh mục</h5>
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                                    <li>
                                        <a href="<?= url('products') ?>" class="text-decoration-none d-flex justify-content-between align-items-center p-2 rounded-3 transition-all <?= !$currentCat && !(($keyword ?? '')) ? 'bg-primary text-white fw-medium shadow-sm' : 'text-dark hover-bg-light hover-text-primary' ?>">
                                            Tất cả
                                        </a>
                                    </li>
                                    <?php foreach ($categories as $c): ?>
                                    <li>
                                        <a href="<?= url('category/' . e($c['slug'])) ?>"
                                           class="text-decoration-none d-flex justify-content-between align-items-center p-2 rounded-3 transition-all <?= ($currentCat && $currentCat['id'] == $c['id']) ? 'bg-primary text-white fw-medium shadow-sm' : 'text-dark hover-bg-light hover-text-primary' ?>">
                                            <span><?= e($c['name']) ?></span>
                                            <span class="badge rounded-pill <?= ($currentCat && $currentCat['id'] == $c['id']) ? 'bg-white text-primary' : 'bg-light text-secondary' ?>"><?= (int)$c['product_count'] ?></span>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Price range -->
                            <div class="mb-4 pb-4 border-bottom">
                                <h5 class="fw-bold mb-3 fs-6 text-uppercase text-secondary tracking-wide">Khoảng giá (₫)</h5>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <input type="number" name="price_min" class="form-control form-control-sm text-center shadow-none border-secondary" placeholder="TỪ"
                                           value="<?= e($_GET['price_min'] ?? '') ?>">
                                    <span class="text-muted">–</span>
                                    <input type="number" name="price_max" class="form-control form-control-sm text-center shadow-none border-secondary" placeholder="ĐẾN"
                                           value="<?= e($_GET['price_max'] ?? '') ?>">
                                </div>
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100 fw-medium py-2 rounded-3 text-uppercase tracking-wider fs-7">Áp dụng</button>
                            </div>

                            <!-- Rating -->
                            <div class="mb-4 pb-4 border-bottom">
                                <h5 class="fw-bold mb-3 fs-6 text-uppercase text-secondary tracking-wide">Đánh giá</h5>
                                <div class="d-flex flex-column gap-2">
                                    <?php foreach ([5,4,3] as $stars): ?>
                                    <div class="form-check cursor-pointer">
                                        <input class="form-check-input border-secondary shadow-none cursor-pointer" type="radio" name="rating" id="rating<?= $stars ?>" value="<?= $stars ?>"
                                               <?= (($_GET['rating'] ?? '') == $stars) ? 'checked' : '' ?>>
                                        <label class="form-check-label d-flex align-items-center gap-1 cursor-pointer" for="rating<?= $stars ?>">
                                            <div class="text-warning lh-1">
                                                <?= str_repeat('<i class="fas fa-star"></i>', $stars) . str_repeat('<i class="far fa-star"></i>', 5 - $stars) ?>
                                            </div>
                                            <span class="text-muted small ms-1 d-none d-xl-inline"><?= $stars < 5 ? 'trở lên' : '' ?></span>
                                        </label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Shipping -->
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 fs-6 text-uppercase text-secondary tracking-wide">Dịch vụ</h5>
                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check cursor-pointer">
                                        <input class="form-check-input border-secondary shadow-none cursor-pointer" type="checkbox" name="freeship" id="freeship" value="1"
                                               <?= isset($_GET['freeship']) ? 'checked' : '' ?>>
                                        <label class="form-check-label text-success fw-medium cursor-pointer" for="freeship">
                                            <i class="fas fa-shipping-fast shadow-none"></i> Freeship
                                        </label>
                                    </div>
                                    <div class="form-check cursor-pointer">
                                        <input class="form-check-input border-secondary shadow-none cursor-pointer" type="checkbox" name="fast_delivery" id="fast_delivery" value="1"
                                               <?= isset($_GET['fast_delivery']) ? 'checked' : '' ?>>
                                        <label class="form-check-label text-primary fw-medium cursor-pointer" for="fast_delivery">
                                            <i class="fas fa-bolt shadow-none"></i> Giao nhanh 2H
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Use a submit button to apply filters -->
                            <div class="mt-4 pt-3 border-top d-flex gap-2">
                                <a href="<?= url($baseRoute . (isset($keyword) && $keyword ? '?q=' . urlencode($keyword) : '')) ?>" class="btn btn-light flex-grow-1 d-lg-none">Xóa</a>
                                <button type="submit" class="btn btn-primary flex-grow-1 shadow-sm">Áp dụng bộ lọc</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- PRODUCTS -->
            <div class="col-lg-9">
                <?php if ($empty ?? false): ?>
                <div class="bg-light rounded-4 p-5 text-center d-flex flex-column align-items-center justify-content-center h-100" style="min-height: 400px; border: 1px dashed #dee2e6;">
                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mb-4" style="width: 120px; height: 120px;">
                        <span class="material-symbols-rounded text-secondary" style="font-size: 64px;">search_off</span>
                    </div>
                    <h2 class="h3 fw-bold mb-3 text-dark">Không tìm thấy sản phẩm phù hợp</h2>
                    <p class="text-muted mb-4 fs-5">Hãy thử điều chỉnh bộ lọc hoặc sử dụng từ khoá khác.</p>
                    <a href="<?= url('products') ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm fw-medium">Xem tất cả sản phẩm</a>
                </div>
                <?php else: ?>
                <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-md-4 mb-5">
                    <?php foreach ($products as $prod): ?>
                    <div class="col">
                        <?php include ROOT_PATH . '/views/partials/product-card.php'; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- Pagination wrapper to center it -->
                <div class="d-flex justify-content-center mt-5">
                    <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

