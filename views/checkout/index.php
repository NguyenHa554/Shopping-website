<?php
// Checkout view — Expects: $items, $subtotal, $shipping, $user
$total = $subtotal + $shipping;
?>

<!-- STEP PROGRESS BAR -->
<div class="checkout-steps">
    <div class="container">
        <div class="steps-bar">
            <div class="step completed">
                <span class="step-icon"><span class="material-icons-round">shopping_cart</span></span>
                <span class="step-label">Giỏ hàng</span>
            </div>
            <div class="step-line"></div>
            <div class="step active">
                <span class="step-icon"><span class="material-icons-round">credit_card</span></span>
                <span class="step-label">Thanh toán</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <span class="step-icon"><span class="material-icons-round">check_circle</span></span>
                <span class="step-label">Hoàn tất</span>
            </div>
        </div>
    </div>
</div>

<section class="page-hero" style="padding:24px 0 16px">
    <div class="container">
        <h1>Thanh toán</h1>
        <nav class="breadcrumb">
            <a href="<?= url() ?>">Trang chủ</a><span>/</span>
            <a href="<?= url('cart') ?>">Giỏ hàng</a><span>/</span>
            <span>Thanh toán</span>
        </nav>
    </div>
</section>

<section class="section checkout-section">
    <div class="container checkout-layout">

        <form action="<?= url('checkout') ?>" method="POST" id="checkoutForm" novalidate>
            <?= csrfField() ?>

            <!-- 1. Shipping info -->
            <div class="checkout-form-panel">
                <h2>1. Thông tin giao hàng</h2>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="full_name">Họ và tên <span class="required">*</span></label>
                        <input type="text" id="full_name" name="full_name" class="form-control"
                               value="<?= e($user['full_name'] ?? '') ?>" required>
                        <span class="field-error" id="nameErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" class="form-control"
                               value="<?= e($user['phone'] ?? '') ?>" required>
                        <span class="field-error" id="phoneErr"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-control"
                           value="<?= e($user['email'] ?? '') ?>" required>
                    <span class="field-error" id="emailErr"></span>
                </div>

                <!-- Address split into province / district / detail -->
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="province">Tỉnh / Thành phố <span class="required">*</span></label>
                        <select id="province" name="province" class="form-control" required>
                            <option value="">-- Chọn tỉnh/thành --</option>
                            <option value="HCM" <?= (($user['province'] ?? '') === 'HCM') ? 'selected' : '' ?>>TP. Hồ Chí Minh</option>
                            <option value="HN"  <?= (($user['province'] ?? '') === 'HN')  ? 'selected' : '' ?>>Hà Nội</option>
                            <option value="DN"  <?= (($user['province'] ?? '') === 'DN')  ? 'selected' : '' ?>>Đà Nẵng</option>
                            <option value="CT"  <?= (($user['province'] ?? '') === 'CT')  ? 'selected' : '' ?>>Cần Thơ</option>
                            <option value="OTHER" <?= !in_array(($user['province'] ?? ''), ['HCM','HN','DN','CT']) && !empty($user['province']) ? 'selected' : '' ?>>Tỉnh / Thành khác</option>
                        </select>
                        <span class="field-error" id="provErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="district">Quận / Huyện <span class="required">*</span></label>
                        <input type="text" id="district" name="district" class="form-control"
                               placeholder="Nhập quận/huyện"
                               value="<?= e($user['district'] ?? '') ?>" required>
                        <span class="field-error" id="distErr"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ cụ thể <span class="required">*</span></label>
                    <textarea id="address" name="address" class="form-control" rows="2"
                              placeholder="Số nhà, tên đường, phường/xã..." required><?= e($user['address'] ?? '') ?></textarea>
                    <span class="field-error" id="addrErr"></span>
                </div>
                <div class="form-group">
                    <label for="note">Ghi chú (tùy chọn)</label>
                    <textarea id="note" name="note" class="form-control" rows="2"
                              placeholder="Giao ngoài giờ hành chính, v.v."></textarea>
                </div>
            </div>

            <!-- 2. Payment method -->
            <div class="checkout-form-panel">
                <h2>2. Phương thức thanh toán</h2>
                <div class="payment-options">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <span class="payment-label">
                            <i class="fa fa-money-bill-wave"></i>
                            <span>Thanh toán khi nhận hàng (COD)</span>
                        </span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="bank_transfer">
                        <span class="payment-label">
                            <i class="fa fa-university"></i>
                            <span>Chuyển khoản ngân hàng</span>
                        </span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="credit_card">
                        <span class="payment-label">
                            <i class="fa fa-credit-card"></i>
                            <span>Thẻ tín dụng / Thẻ ghi nợ</span>
                        </span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="momo">
                        <span class="payment-label">
                            <i class="fa fa-wallet"></i>
                            <span>Ví MoMo</span>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Place order button (mobile only, shown below form) -->
            <button type="submit" class="btn btn-primary btn-block btn-place-order-mobile" id="placeOrderBtnMobile">
                <i class="fa fa-lock"></i> Đặt hàng (<?= formatPrice($total) ?>)
            </button>
        </form>

        <!-- Order summary sidebar -->
        <aside class="checkout-summary">
            <h2>Đơn hàng của bạn</h2>
            <?php foreach ($items as $item):
                $unitPrice = (float)($item['sale_price'] ?? $item['price']);
            ?>
            <div class="order-line">
                <img src="<?= asset(e($item['cover_image'] ?? '')) ?>" alt="<?= e($item['name']) ?>">
                <div class="order-line-info">
                    <span class="order-line-name"><?= e($item['name']) ?></span>
                    <?php if (!empty($item['variant'])): ?>
                    <span class="order-line-variant"><?= e($item['variant']) ?></span>
                    <?php endif; ?>
                    <span class="order-line-qty">x<?= (int)$item['quantity'] ?></span>
                </div>
                <span class="order-line-price"><?= formatPrice($unitPrice * (int)$item['quantity']) ?></span>
            </div>
            <?php endforeach; ?>
            <div class="summary-divider"></div>
            <div class="summary-row"><span>Tạm tính</span><span><?= formatPrice($subtotal) ?></span></div>
            <div class="summary-row"><span>Phí vận chuyển</span><span><?= $shipping > 0 ? formatPrice($shipping) : 'Miễn phí' ?></span></div>
            <div class="summary-divider"></div>
            <div class="summary-row summary-total"><span>Tổng cộng</span><span><?= formatPrice($total) ?></span></div>
            <button type="submit" form="checkoutForm" class="btn btn-primary btn-block" id="placeOrderBtn">
                <i class="fa fa-lock"></i> Đặt hàng (<?= formatPrice($total) ?>)
            </button>
        </aside>
    </div>
</section>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    let ok = true;
    const checks = [
        ['full_name','nameErr','Họ tên là bắt buộc.'],
        ['phone','phoneErr','Số điện thoại không hợp lệ.'],
        ['email','emailErr','Email không hợp lệ.'],
        ['province','provErr','Vui lòng chọn tỉnh/thành phố.'],
        ['district','distErr','Vui lòng nhập quận/huyện.'],
        ['address','addrErr','Địa chỉ là bắt buộc.'],
    ];
    checks.forEach(([fid, eid, msg]) => {
        const f = document.getElementById(fid), er = document.getElementById(eid);
        if (f && er) { if (!f.value.trim()) { er.textContent = msg; ok = false; } else er.textContent = ''; }
    });
    const phoneVal = document.getElementById('phone').value.trim();
    if (phoneVal && !/^\d{9,12}$/.test(phoneVal)) {
        document.getElementById('phoneErr').textContent = 'Số điện thoại phải từ 9–12 chữ số.'; ok = false;
    }
    const emailVal = document.getElementById('email').value.trim();
    if (emailVal && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
        document.getElementById('emailErr').textContent = 'Email không hợp lệ.'; ok = false;
    }
    if (!ok) e.preventDefault();
});
</script>
