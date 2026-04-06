<?php
// Cart view — Expects: $items (array of cart rows with shop grouping), isLoggedIn()
$isGuest = !isLoggedIn();

// Group items by shop (seller_id / shop_name)
$shopGroups = [];
if (!$isGuest && !empty($items)) {
    foreach ($items as $item) {
        $shopId   = $item['shop_id']   ?? 0;
        $shopName = $item['shop_name'] ?? 'Cửa hàng';
        if (!isset($shopGroups[$shopId])) {
            $shopGroups[$shopId] = ['name' => $shopName, 'is_mall' => ($item['is_mall'] ?? false), 'items' => []];
        }
        $shopGroups[$shopId]['items'][] = $item;
    }
}
?>

<!-- PAGE HERO -->
<div class="bg-light py-4 py-lg-5 border-bottom mb-4 mb-lg-5">
    <div class="container text-center text-md-start d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div>
            <h1 class="display-6 fw-bold mb-2 font-playfair">Giỏ hàng</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 justify-content-center justify-content-md-start">
                    <li class="breadcrumb-item"><a href="<?= url() ?>" class="text-decoration-none text-muted hover-primary">Trang chủ</a></li>
                    <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">Giỏ hàng</li>
                </ol>
            </nav>
        </div>
        <a href="<?= url('products') ?>" class="btn btn-outline-primary rounded-pill d-flex align-items-center gap-2 px-4 shadow-sm">
            <span class="material-symbols-rounded fs-5">arrow_back</span> Tiếp tục mua sắm
        </a>
    </div>
</div>

<section class="py-2 pb-5">
    <div class="container">

        <!-- Page title bar -->
        <div class="d-flex align-items-end gap-2 mb-4">
            <h2 class="h3 fw-bold mb-0">Giỏ hàng của bạn</h2>
            <span class="text-muted fs-5 pb-1" id="cart-count-label">(<?= array_sum(array_column($items ?? [], 'quantity')) ?> sản phẩm)</span>
        </div>

        <?php if (!$isGuest && !empty($shopGroups)): ?>
        <div class="row g-4 g-xl-5" id="cart-layout">
            <!-- LEFT: Items -->
            <div class="col-lg-8">
                <!-- Bulk actions bar -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-3 p-md-4 d-flex justify-content-between align-items-center">
                        <div class="form-check d-flex align-items-center gap-2 m-0 cursor-pointer">
                            <input class="form-check-input mt-0 border-secondary" type="checkbox" id="select-all-chk" style="width: 20px; height: 20px; cursor: pointer;">
                            <label class="form-check-label fw-medium text-dark mt-1 cursor-pointer select-none" for="select-all-chk">
                                Chọn tất cả (<span id="selected-counter" class="text-primary fw-bold">0</span>)
                            </label>
                        </div>
                        <button class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1 rounded-pill px-3" id="bulk-delete-btn">
                            <span class="material-symbols-rounded fs-6">delete_outline</span> Xóa đã chọn
                        </button>
                    </div>
                </div>

                <?php foreach ($shopGroups as $shopId => $shop): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden cart-shop-group">
                    <div class="card-header bg-white border-bottom p-3 p-md-4 d-flex align-items-center gap-3">
                        <input class="form-check-input mt-0 border-secondary shop-chk flex-shrink-0" type="checkbox" data-shop="<?= (int)$shopId ?>" style="width: 20px; height: 20px; cursor: pointer;">
                        <span class="material-symbols-rounded fs-4 text-secondary">storefront</span>
                        <span class="fw-bold fs-5 text-dark"><?= e($shop['name']) ?></span>
                        <?php if ($shop['is_mall']): ?>
                        <span class="badge bg-danger rounded-pill px-2 py-1 align-self-center"><i class="fas fa-gem me-1 small"></i>Mall</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                        <?php 
                        $itemCount = count($shop['items']);
                        foreach ($shop['items'] as $index => $item):
                            $unitPrice = (float)($item['sale_price'] ?? $item['price']);
                            $origPrice = (float)$item['price'];
                            $hasSale   = $item['sale_price'] && $unitPrice < $origPrice;
                            $subtotal  = $unitPrice * (int)$item['quantity'];
                            $disc      = $hasSale ? round((1 - $unitPrice / $origPrice) * 100) : 0;
                        ?>
                        <div class="list-group-item p-3 p-md-4 cart-item position-relative bg-white border-0 <?= $index < $itemCount - 1 ? 'border-bottom' : '' ?>" data-shop="<?= (int)$shopId ?>" data-id="<?= (int)$item['product_id'] ?>">
                            <div class="row align-items-center g-3">
                                <div class="col-auto d-flex align-items-center gap-3">
                                    <input class="form-check-input mt-0 border-secondary item-chk" type="checkbox" style="width: 20px; height: 20px; cursor: pointer;">
                                    <a href="<?= url('product/' . e($item['slug'])) ?>" class="d-block overflow-hidden rounded-3 border" style="width: 80px; height: 80px;">
                                        <img src="<?= asset(e($item['cover_image'] ?? '')) ?>" alt="<?= e($item['name']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="<?= url('product/' . e($item['slug'])) ?>" class="text-decoration-none text-dark fw-medium d-block mb-1 text-truncate pe-4 fs-6 hover-primary"><?= e($item['name']) ?></a>
                                    <?php if (!empty($item['variant'])): ?>
                                    <div class="text-muted small mb-2 bg-light d-inline-block px-2 py-1 rounded-2">Phân loại: <?= e($item['variant']) ?></div>
                                    <?php endif; ?>
                                    <div class="d-flex flex-wrap align-items-end gap-2 lh-1 text-nowrap">
                                        <span class="fs-5 fw-bold text-danger"><?= formatPrice($unitPrice) ?></span>
                                        <?php if ($hasSale): ?>
                                        <span class="small text-decoration-line-through text-muted"><?= formatPrice($origPrice) ?></span>
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill border border-danger border-opacity-25 px-1 py-0">-<?= $disc ?>%</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-auto ms-auto d-flex flex-column align-items-end gap-3 justify-content-between h-100">
                                    <div class="fw-bold text-primary fs-5 text-end cart-item-subtotal"><?= formatPrice($subtotal) ?></div>
                                    <div class="input-group input-group-sm" style="width: 110px;">
                                        <button class="btn btn-outline-secondary dec-btn px-2" type="button" aria-label="Giảm"><i class="fas fa-minus fs-7"></i></button>
                                        <input type="number" class="form-control text-center fw-medium border-secondary px-0 qty-input" value="<?= (int)$item['quantity'] ?>" min="1" max="<?= (int)$item['stock'] ?>" data-id="<?= (int)$item['product_id'] ?>">
                                        <button class="btn btn-outline-secondary inc-btn px-2" type="button" aria-label="Tăng"><i class="fas fa-plus fs-7"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-link text-muted hover-opacity-100 position-absolute top-0 end-0 mt-2 me-2 p-2 remove-item-btn cart-item-remove" data-id="<?= (int)$item['product_id'] ?>" aria-label="Xóa sản phẩm">
                                    <span class="material-symbols-rounded">close</span>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- RIGHT: Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 2rem; z-index: 10;">
                    <div class="card-header bg-white border-bottom p-4">
                        <h3 class="h5 fw-bold mb-0">Tóm tắt đơn hàng</h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- Voucher -->
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-medium mb-2 d-flex align-items-center gap-1"><span class="material-symbols-rounded fs-6 text-primary">local_offer</span> Mã giảm giá</label>
                            <div class="input-group">
                                <input type="text" class="form-control border-secondary shadow-none" placeholder="Nhập mã..." id="voucher-input" style="text-transform: uppercase;">
                                <button class="btn btn-primary px-3 fw-medium" type="button" id="voucher-apply">Áp dụng</button>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-3 mb-4 text-secondary">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Tạm tính</span>
                                <span class="fw-medium text-dark" id="summarySubtotal">0 ₫</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Giảm giá</span>
                                <span class="fw-medium text-danger" id="summaryDiscount">–0 ₫</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Phí vận chuyển</span>
                                <span class="fw-medium text-success" id="summaryShipping">Miễn phí từ 500K</span>
                            </div>
                        </div>

                        <div class="border-top pt-3 pb-4 mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark fs-5">Tổng thanh toán</span>
                                <span class="fw-bold text-danger fs-3 lh-1" id="summaryTotal">0 ₫</span>
                            </div>
                            <p class="text-muted small text-end mb-0">(Đã bao gồm VAT)</p>
                        </div>

                        <a href="<?= url('checkout') ?>" class="btn btn-primary btn-lg w-100 rounded-pill d-flex gap-2 justify-content-center align-items-center shadow-sm fw-bold fs-5 mb-2" id="checkoutBtn">
                            Tiến hành đặt hàng <span class="material-symbols-rounded">arrow_forward</span>
                        </a>
                        <p class="text-center text-muted small mb-0 mt-3"><i class="fas fa-lock me-1 text-secondary opacity-50"></i>Thanh toán an toàn, bảo mật</p>
                    </div>
                </div>
            </div>
        </div>

        <?php elseif ($isGuest): ?>
        <!-- Guest cart rendered by sonne.js -->
        <div class="row g-4 g-xl-5" id="cart-layout">
            <div class="col-lg-8" id="guestCartItems">
                <!-- Rendered by sonne.js -->
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 2rem;">
                    <div class="card-header bg-white border-bottom p-4">
                        <h3 class="h5 fw-bold mb-0">Tóm tắt đơn hàng</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex flex-column gap-3 mb-4 text-secondary">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Tạm tính</span>
                                <span class="fw-medium text-dark" id="summarySubtotal">0 ₫</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Phí vận chuyển</span>
                                <span class="fw-medium text-success" id="summaryShipping">Miễn phí từ 500K</span>
                            </div>
                        </div>
                        <div class="border-top pt-3 pb-4 mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark fs-5">Tổng thanh toán</span>
                                <span class="fw-bold text-danger fs-3 lh-1" id="summaryTotal">0 ₫</span>
                            </div>
                        </div>
                        <a href="<?= url('checkout') ?>" class="btn btn-primary btn-lg w-100 rounded-pill d-flex gap-2 justify-content-center align-items-center shadow-sm fw-bold fs-5 mb-2" id="checkoutBtn">
                            Tiến hành đặt hàng <span class="material-symbols-rounded">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php else: ?>
        <!-- Empty state -->
        <div class="card border-0 shadow-sm rounded-4 text-center py-5" id="cart-empty" style="border: 2px dashed #dee2e6 !important;">
            <div class="card-body py-5 d-flex flex-column align-items-center justify-content-center">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-4 text-secondary" style="width: 140px; height: 140px;">
                    <span class="material-symbols-rounded" style="font-size: 80px;">shopping_cart</span>
                </div>
                <h2 class="h3 fw-bold text-dark mb-3">Giỏ hàng của bạn đang trống</h2>
                <p class="text-muted fs-5 mb-5 px-3">Hãy khám phá hàng triệu sản phẩm chất lượng trên SONNE!</p>
                <a href="<?= url('products') ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm fw-medium d-inline-flex align-items-center gap-2">
                    <span class="material-symbols-rounded">explore</span> Khám phá sản phẩm
                </a>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- TOAST functionality relies on Bootstrap Toast shown via generic JS or inline JS here. -->
<!-- Make sure we don't duplicate if global layout has it. We will use the layout component or keep it simple. -->

<script>
// Bulk select
const selectAllChk = document.getElementById('select-all-chk');
const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
const counterEl = document.getElementById('selected-counter');

function getItemChks() { return document.querySelectorAll('.item-chk'); }
function getShopChks() { return document.querySelectorAll('.shop-chk'); }

function updateCounter() {
    const items = getItemChks();
    const selected = document.querySelectorAll('.item-chk:checked').length;
    if (counterEl) counterEl.textContent = selected;
    if (selectAllChk) {
        selectAllChk.checked = items.length > 0 && selected === items.length;
        selectAllChk.indeterminate = selected > 0 && selected < items.length;
    }
}

if (selectAllChk) {
    selectAllChk.addEventListener('change', () => {
        getItemChks().forEach(c => c.checked = selectAllChk.checked);
        getShopChks().forEach(c => c.checked = selectAllChk.checked);
        updateCounter();
    });
}

getShopChks().forEach(shopChk => {
    shopChk.addEventListener('change', () => {
        const shopId = shopChk.dataset.shop;
        document.querySelectorAll(`.cart-item[data-shop="${shopId}"] .item-chk`).forEach(c => c.checked = shopChk.checked);
        updateCounter();
    });
});

getItemChks().forEach(c => c.addEventListener('change', updateCounter));

// Bulk delete
if (bulkDeleteBtn) {
    bulkDeleteBtn.addEventListener('click', () => {
        const selected = document.querySelectorAll('.item-chk:checked');
        if(selected.length === 0) return;
        selected.forEach(chk => {
            const row = chk.closest('.cart-item');
            if (row) { row.style.transition = 'opacity .3s, transform .3s'; row.style.opacity = '0'; row.style.transform = 'translateY(24px)'; setTimeout(() => row.remove(), 300); }
        });
        updateCounter();
        if(typeof showToast === 'function') { showToast('Đã xóa sản phẩm đã chọn'); }
    });
}

// Qty & remove per item
document.querySelectorAll('.cart-shop-group').forEach(group => {
    group.querySelectorAll('.cart-item').forEach(item => {
        const qtyInput = item.querySelector('.qty-input');
        item.querySelector('.dec-btn')?.addEventListener('click', () => { if (qtyInput && +qtyInput.value > 1) qtyInput.value = +qtyInput.value - 1; });
        item.querySelector('.inc-btn')?.addEventListener('click', () => { if (qtyInput) qtyInput.value = Math.min(+qtyInput.max || 99, +qtyInput.value + 1); });
        item.querySelector('.remove-item-btn')?.addEventListener('click', () => {
            item.style.transition = 'opacity .3s, transform .3s'; item.style.opacity = '0'; item.style.transform = 'translateY(24px)';
            setTimeout(() => { item.remove(); updateCounter(); }, 300);
            if(typeof showToast === 'function') { showToast('Đã xóa sản phẩm khỏi giỏ hàng'); }
        });
    });
});

// Voucher
const voucherApply = document.getElementById('voucher-apply');
if (voucherApply) {
    voucherApply.addEventListener('click', () => {
        const code = (document.getElementById('voucher-input')?.value || '').trim().toUpperCase();
        if (code === 'SONNE10') {
            document.getElementById('summaryDiscount') && (document.getElementById('summaryDiscount').textContent = '–10%');
            if(typeof showToast === 'function') { showToast('Áp dụng mã SONNE10 thành công! Giảm 10%', 'success'); }
        } else {
            if(typeof showToast === 'function') { showToast('Mã giảm giá không hợp lệ hoặc đã hết hạn', 'error'); }
        }
    });
}
</script>
