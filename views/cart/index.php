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
<section class="page-hero">
    <div class="container">
        <h1>Giỏ hàng</h1>
        <nav class="breadcrumb"><a href="<?= url() ?>">Trang chủ</a><span>/</span><span>Giỏ hàng</span></nav>
    </div>
</section>

<section class="section cart-section">
    <div class="container">

        <!-- Page title bar -->
        <div class="page-title-bar">
            <h2 class="page-title">
                Giỏ hàng
                <span id="cart-count-label">(<?= array_sum(array_column($items ?? [], 'quantity')) ?> sản phẩm)</span>
            </h2>
            <a href="<?= url('products') ?>" class="back-link">
                <span class="material-icons-round">arrow_back</span> Tiếp tục mua sắm
            </a>
        </div>

        <?php if (!$isGuest && !empty($shopGroups)): ?>
        <div class="cart-layout" id="cart-layout">
            <!-- LEFT: Items -->
            <div class="cart-items-col">

                <!-- Bulk actions bar -->
                <div class="bulk-actions-bar">
                    <label class="custom-check">
                        <input type="checkbox" id="select-all-chk">
                        <span class="check-box"></span>
                        Chọn tất cả (<span id="selected-counter">0</span>)
                    </label>
                    <button class="bulk-delete-btn" id="bulk-delete-btn">
                        <span class="material-icons-round">delete_outline</span> Xóa đã chọn
                    </button>
                </div>

                <?php foreach ($shopGroups as $shopId => $shop): ?>
                <div class="cart-shop-group">
                    <div class="shop-group-header">
                        <label class="custom-check">
                            <input type="checkbox" class="shop-chk" data-shop="<?= (int)$shopId ?>">
                            <span class="check-box"></span>
                        </label>
                        <span class="material-icons-round shop-icon">storefront</span>
                        <span class="shop-group-name"><?= e($shop['name']) ?></span>
                        <?php if ($shop['is_mall']): ?>
                        <span class="badge-mall" style="margin-left:8px">Mall</span>
                        <?php endif; ?>
                    </div>

                    <?php foreach ($shop['items'] as $item):
                        $unitPrice = (float)($item['sale_price'] ?? $item['price']);
                        $origPrice = (float)$item['price'];
                        $hasSale   = $item['sale_price'] && $unitPrice < $origPrice;
                        $subtotal  = $unitPrice * (int)$item['quantity'];
                        $disc      = $hasSale ? round((1 - $unitPrice / $origPrice) * 100) : 0;
                    ?>
                    <div class="cart-item" data-shop="<?= (int)$shopId ?>" data-id="<?= (int)$item['product_id'] ?>">
                        <label class="custom-check">
                            <input type="checkbox" class="item-chk">
                            <span class="check-box"></span>
                        </label>
                        <a href="<?= url('product/' . e($item['slug'])) ?>">
                            <img src="<?= asset(e($item['cover_image'] ?? '')) ?>"
                                 alt="<?= e($item['name']) ?>" class="cart-item-img" loading="lazy">
                        </a>
                        <div class="cart-item-info">
                            <a href="<?= url('product/' . e($item['slug'])) ?>" class="cart-item-name"><?= e($item['name']) ?></a>
                            <?php if (!empty($item['variant'])): ?>
                            <div class="cart-item-variant">Phân loại: <?= e($item['variant']) ?></div>
                            <?php endif; ?>
                            <div class="cart-item-price-row">
                                <?php if ($hasSale): ?>
                                <span class="cart-old-price"><?= formatPrice($origPrice) ?></span>
                                <?php endif; ?>
                                <span class="cart-unit-price"><?= formatPrice($unitPrice) ?></span>
                                <?php if ($disc > 0): ?>
                                <span class="disc-badge">-<?= $disc ?>%</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="cart-item-qty">
                            <div class="qty-control">
                                <button class="qty-btn dec-btn cart-qty-dec"
                                        data-id="<?= (int)$item['product_id'] ?>" aria-label="Giảm">
                                    <span class="material-icons-round">remove</span>
                                </button>
                                <input type="number" value="<?= (int)$item['quantity'] ?>" min="1"
                                       max="<?= (int)$item['stock'] ?>" class="qty-input cart-qty-input"
                                       data-id="<?= (int)$item['product_id'] ?>">
                                <button class="qty-btn inc-btn cart-qty-inc"
                                        data-id="<?= (int)$item['product_id'] ?>" aria-label="Tăng">
                                    <span class="material-icons-round">add</span>
                                </button>
                            </div>
                        </div>
                        <div class="cart-item-subtotal"><?= formatPrice($subtotal) ?></div>
                        <button class="remove-item-btn cart-item-remove"
                                data-id="<?= (int)$item['product_id'] ?>" aria-label="Xóa sản phẩm">
                            <span class="material-icons-round">delete_outline</span>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- RIGHT: Order Summary -->
            <div class="cart-summary-col">
                <div class="order-summary-card">
                    <h2 class="summary-title">Tóm tắt đơn hàng</h2>

                    <!-- Voucher -->
                    <div class="voucher-row">
                        <span class="material-icons-round">local_offer</span>
                        <input type="text" class="voucher-input" placeholder="Nhập mã giảm giá" id="voucher-input">
                        <button class="voucher-apply-btn" id="voucher-apply">Áp dụng</button>
                    </div>

                    <div class="summary-lines">
                        <div class="summary-line">
                            <span>Tạm tính</span>
                            <span id="summarySubtotal">0 ₫</span>
                        </div>
                        <div class="summary-line">
                            <span>Giảm giá</span>
                            <span class="text-danger" id="summaryDiscount">–0 ₫</span>
                        </div>
                        <div class="summary-line">
                            <span>Phí vận chuyển</span>
                            <span class="text-success" id="summaryShipping">Miễn phí từ 500K</span>
                        </div>
                    </div>

                    <div class="summary-total-row">
                        <span>Tổng thanh toán</span>
                        <span class="summary-total" id="summaryTotal">0 ₫</span>
                    </div>

                    <a href="<?= url('checkout') ?>" class="btn btn-primary btn-block checkout-cta" id="checkoutBtn">
                        <span class="material-icons-round">arrow_forward</span> Tiến hành thanh toán
                    </a>
                    <p class="summary-note">Bạn sẽ xác nhận địa chỉ và phương thức thanh toán ở bước tiếp theo.</p>
                    <a href="<?= url('products') ?>" class="btn btn-ghost btn-block" style="margin-top:8px">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>

        <?php elseif ($isGuest): ?>
        <!-- Guest cart rendered by sonne.js -->
        <div class="cart-layout" id="cart-layout">
            <div class="cart-items-col" id="guestCartItems">
                <!-- Rendered by sonne.js -->
            </div>
            <div class="cart-summary-col">
                <div class="order-summary-card">
                    <h2 class="summary-title">Tóm tắt đơn hàng</h2>
                    <div class="summary-lines">
                        <div class="summary-line"><span>Tạm tính</span><span id="summarySubtotal">0 ₫</span></div>
                        <div class="summary-line"><span>Phí vận chuyển</span><span id="summaryShipping">Miễn phí từ 500K</span></div>
                    </div>
                    <div class="summary-total-row">
                        <span>Tổng thanh toán</span>
                        <span class="summary-total" id="summaryTotal">0 ₫</span>
                    </div>
                    <a href="<?= url('checkout') ?>" class="btn btn-primary btn-block checkout-cta" id="checkoutBtn">
                        <span class="material-icons-round">arrow_forward</span> Tiến hành thanh toán
                    </a>
                </div>
            </div>
        </div>

        <?php else: ?>
        <!-- Empty state -->
        <div class="cart-empty" id="cart-empty">
            <div class="empty-illustration">
                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" width="160">
                    <circle cx="100" cy="100" r="80" fill="#F5F5F5"/>
                    <rect x="60" y="70" width="80" height="70" rx="10" fill="#E0E0E0"/>
                    <path d="M75 70 L80 50 L120 50 L125 70" stroke="#BDBDBD" stroke-width="3" fill="none" stroke-linecap="round"/>
                    <circle cx="80" cy="145" r="8" fill="#BDBDBD"/>
                    <circle cx="120" cy="145" r="8" fill="#BDBDBD"/>
                    <path d="M85 95 Q100 110 115 95" stroke="#9E9E9E" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                </svg>
            </div>
            <h2 class="empty-title">Giỏ hàng của bạn đang trống</h2>
            <p class="empty-sub">Hãy khám phá hàng triệu sản phẩm trên SONNE!</p>
            <a href="<?= url('products') ?>" class="btn btn-primary">
                <span class="material-icons-round">explore</span> Khám phá sản phẩm
            </a>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- TOAST -->
<div class="toast" id="toast">
    <span class="material-icons-round">check_circle</span>
    <span id="toast-msg">Đã cập nhật giỏ hàng!</span>
</div>

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
        document.querySelectorAll('.item-chk:checked').forEach(chk => {
            const row = chk.closest('.cart-item');
            if (row) { row.style.transition = 'opacity .3s,transform .3s'; row.style.opacity = '0'; row.style.transform = 'translateX(24px)'; setTimeout(() => row.remove(), 300); }
        });
        updateCounter();
        showToast('Đã xóa sản phẩm đã chọn');
    });
}

// Qty & remove per item
document.querySelectorAll('.cart-shop-group').forEach(group => {
    group.querySelectorAll('.cart-item').forEach(item => {
        const qtyInput = item.querySelector('.qty-input');
        item.querySelector('.dec-btn')?.addEventListener('click', () => { if (qtyInput && +qtyInput.value > 1) qtyInput.value = +qtyInput.value - 1; });
        item.querySelector('.inc-btn')?.addEventListener('click', () => { if (qtyInput) qtyInput.value = Math.min(+qtyInput.max || 99, +qtyInput.value + 1); });
        item.querySelector('.remove-item-btn')?.addEventListener('click', () => {
            item.style.transition = 'opacity .3s,transform .3s'; item.style.opacity = '0'; item.style.transform = 'translateX(24px)';
            setTimeout(() => item.remove(), 300);
            showToast('Đã xóa sản phẩm khỏi giỏ hàng');
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
            showToast('Áp dụng mã SONNE10 thành công! Giảm 10%');
        } else {
            showToast('Mã giảm giá không hợp lệ hoặc đã hết hạn');
        }
    });
}
</script>
