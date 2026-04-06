<?php
// Checkout view — Expects: $items, $subtotal, $shipping, $user
$total = $subtotal + $shipping;
?>

<!-- STEP PROGRESS BAR -->
<div class="bg-light py-4 border-bottom">
    <div class="container pb-2">
        <div class="d-flex justify-content-center align-items-center position-relative mx-auto mt-2" style="max-width: 500px;">
            <div class="position-absolute top-50 start-0 w-100 translate-middle-y z-0" style="height: 3px; background-color: #dee2e6;"></div>
            <div class="position-absolute top-50 start-0 translate-middle-y z-0 bg-success" style="height: 3px; width: 50%;"></div>
            
            <div class="d-flex flex-column align-items-center z-1 position-relative bg-light px-2">
                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                    <span class="material-symbols-rounded fs-5">shopping_cart</span>
                </div>
                <span class="small fw-bold text-success mt-2">Giỏ hàng</span>
            </div>
            
            <div class="d-flex flex-column align-items-center z-1 position-relative bg-light px-2 ms-auto">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm border border-primary border-3" style="width: 40px; height: 40px;">
                    <span class="material-symbols-rounded fs-5">credit_card</span>
                </div>
                <span class="small fw-bold text-primary mt-2">Thanh toán</span>
            </div>
            
            <div class="d-flex flex-column align-items-center z-1 position-relative bg-light px-2 ms-auto">
                <div class="rounded-circle bg-white text-secondary d-flex align-items-center justify-content-center shadow-sm border border-secondary" style="width: 40px; height: 40px;">
                    <span class="material-symbols-rounded fs-5">check_circle</span>
                </div>
                <span class="small fw-medium text-secondary mt-2">Hoàn tất</span>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center gap-2 mb-4">
            <h1 class="h2 fw-bold font-playfair mb-0">Thanh toán thanh toán</h1>
        </div>

        <div class="row g-4 g-lg-5">
            <!-- LEFT: Checkout Form -->
            <div class="col-lg-8">
                <form action="<?= url('checkout') ?>" method="POST" id="checkoutForm" novalidate>
                    <?= csrfField() ?>

                    <!-- 1. Shipping info -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom p-4">
                            <h2 class="h5 fw-bold mb-0 d-flex align-items-center gap-2"><span class="material-symbols-rounded text-primary">local_shipping</span> 1. Thông tin giao hàng</h2>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="full_name" class="form-label fw-medium text-dark">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" id="full_name" name="full_name" class="form-control form-control-lg bg-light border-0 shadow-sm"
                                           value="<?= e($user['full_name'] ?? '') ?>" required>
                                    <div class="invalid-feedback d-block fw-medium" id="nameErr"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-medium text-dark">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" id="phone" name="phone" class="form-control form-control-lg bg-light border-0 shadow-sm"
                                           value="<?= e($user['phone'] ?? '') ?>" required>
                                    <div class="invalid-feedback d-block fw-medium" id="phoneErr"></div>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label fw-medium text-dark">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control form-control-lg bg-light border-0 shadow-sm"
                                           value="<?= e($user['email'] ?? '') ?>" required>
                                    <div class="invalid-feedback d-block fw-medium" id="emailErr"></div>
                                </div>

                                <!-- Address split into province / district / detail -->
                                <div class="col-md-6">
                                    <label for="province" class="form-label fw-medium text-dark">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                    <select id="province" name="province" class="form-select form-select-lg bg-light border-0 shadow-sm" required>
                                        <option value="">-- Chọn tỉnh/thành --</option>
                                        <option value="HCM" <?= (($user['province'] ?? '') === 'HCM') ? 'selected' : '' ?>>TP. Hồ Chí Minh</option>
                                        <option value="HN"  <?= (($user['province'] ?? '') === 'HN')  ? 'selected' : '' ?>>Hà Nội</option>
                                        <option value="DN"  <?= (($user['province'] ?? '') === 'DN')  ? 'selected' : '' ?>>Đà Nẵng</option>
                                        <option value="CT"  <?= (($user['province'] ?? '') === 'CT')  ? 'selected' : '' ?>>Cần Thơ</option>
                                        <option value="OTHER" <?= !in_array(($user['province'] ?? ''), ['HCM','HN','DN','CT']) && !empty($user['province']) ? 'selected' : '' ?>>Tỉnh / Thành khác</option>
                                    </select>
                                    <div class="invalid-feedback d-block fw-medium" id="provErr"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="district" class="form-label fw-medium text-dark">Quận / Huyện <span class="text-danger">*</span></label>
                                    <input type="text" id="district" name="district" class="form-control form-control-lg bg-light border-0 shadow-sm"
                                           placeholder="Nhập quận/huyện"
                                           value="<?= e($user['district'] ?? '') ?>" required>
                                    <div class="invalid-feedback d-block fw-medium" id="distErr"></div>
                                </div>
                                <div class="col-12">
                                    <label for="address" class="form-label fw-medium text-dark">Địa chỉ cụ thể <span class="text-danger">*</span></label>
                                    <textarea id="address" name="address" class="form-control form-control-lg bg-light border-0 shadow-sm" rows="2"
                                              placeholder="Số nhà, tên đường, phường/xã..." required><?= e($user['address'] ?? '') ?></textarea>
                                    <div class="invalid-feedback d-block fw-medium" id="addrErr"></div>
                                </div>
                                <div class="col-12">
                                    <label for="note" class="form-label fw-medium text-dark">Ghi chú (tùy chọn)</label>
                                    <textarea id="note" name="note" class="form-control form-control-lg bg-light border-0 shadow-sm" rows="2"
                                              placeholder="Giao ngoài giờ hành chính, v.v."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Payment method -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom p-4">
                            <h2 class="h5 fw-bold mb-0 d-flex align-items-center gap-2"><span class="material-symbols-rounded text-primary">payments</span> 2. Phương thức thanh toán</h2>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex flex-column gap-3 payment-methods-group">
                                <div class="form-check p-0 mb-0 position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" id="pay_cod" value="cod" checked>
                                    <label class="btn btn-outline-secondary w-100 text-start px-4 py-3 rounded-4 d-flex align-items-center gap-3 border shadow-none" for="pay_cod">
                                        <span class="material-symbols-rounded fs-2 text-primary bg-primary bg-opacity-10 p-2 rounded-3">payments</span>
                                        <span class="fw-medium text-dark fs-5">Thanh toán khi nhận hàng (COD)</span>
                                    </label>
                                </div>
                                <div class="form-check p-0 mb-0 position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" id="pay_bank" value="bank_transfer">
                                    <label class="btn btn-outline-secondary w-100 text-start px-4 py-3 rounded-4 d-flex align-items-center gap-3 border shadow-none" for="pay_bank">
                                        <span class="material-symbols-rounded fs-2 text-info bg-info bg-opacity-10 p-2 rounded-3">account_balance</span>
                                        <span class="fw-medium text-dark fs-5">Chuyển khoản ngân hàng</span>
                                    </label>
                                </div>
                                <div class="form-check p-0 mb-0 position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" id="pay_card" value="credit_card">
                                    <label class="btn btn-outline-secondary w-100 text-start px-4 py-3 rounded-4 d-flex align-items-center gap-3 border shadow-none" for="pay_card">
                                        <span class="material-symbols-rounded fs-2 text-warning bg-warning bg-opacity-10 p-2 rounded-3">credit_card</span>
                                        <span class="fw-medium text-dark fs-5">Thẻ tín dụng / Thẻ ghi nợ</span>
                                    </label>
                                </div>
                                <div class="form-check p-0 mb-0 position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" id="pay_momo" value="momo">
                                    <label class="btn btn-outline-secondary w-100 text-start px-4 py-3 rounded-4 d-flex align-items-center gap-3 border shadow-none" for="pay_momo">
                                        <span class="material-symbols-rounded fs-2 text-danger bg-danger bg-opacity-10 p-2 rounded-3">account_balance_wallet</span>
                                        <span class="fw-medium text-dark fs-5">Ví điện tử MoMo</span>
                                    </label>
                                </div>
                            </div>
                            <style>
                            .payment-methods-group .btn-check:checked + label {
                                border-color: var(--bs-primary) !important;
                                background-color: var(--bs-primary-bg-subtle) !important;
                            }
                            </style>
                        </div>
                    </div>

                    <!-- Place order button (mobile only, shown below form) -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill d-lg-none d-flex justify-content-center align-items-center gap-2 shadow fw-bold mt-4" id="placeOrderBtnMobile">
                        <span class="material-symbols-rounded">lock</span> Đặt hàng (<?= formatPrice($total) ?>)
                    </button>
                </form>
            </div>

            <!-- RIGHT: Order summary sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 2rem;">
                    <div class="card-header bg-primary text-white border-bottom-0 p-4 rounded-top-4">
                        <h3 class="h5 fw-bold mb-0 text-white d-flex align-items-center gap-2"><span class="material-symbols-rounded">receipt_long</span> Đơn hàng của bạn</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush rounded-bottom-4">
                            <?php foreach ($items as $item):
                                $unitPrice = (float)($item['sale_price'] ?? $item['price']);
                            ?>
                            <div class="list-group-item p-4 border-bottom">
                                <div class="d-flex gap-3 align-items-start">
                                    <img src="<?= asset(e($item['cover_image'] ?? '')) ?>" alt="<?= e($item['name']) ?>" class="rounded-3 border object-fit-cover shadow-sm bg-light" style="width: 60px; height: 60px;">
                                    <div class="d-flex flex-column flex-grow-1 min-w-0">
                                        <h4 class="h6 fw-medium text-dark mb-1 d-block text-truncate"><?= e($item['name']) ?></h4>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <?php if (!empty($item['variant'])): ?>
                                                <span class="badge bg-light text-secondary rounded-pill fw-normal"><?= e($item['variant']) ?></span>
                                                <?php endif; ?>
                                                <span class="text-muted small ms-1">x<?= (int)$item['quantity'] ?></span>
                                            </div>
                                            <span class="fw-bold text-dark"><?= formatPrice($unitPrice * (int)$item['quantity']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                            <div class="p-4 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-secondary fw-medium">Tạm tính</span>
                                    <span class="fw-medium text-dark"><?= formatPrice($subtotal) ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-secondary fw-medium">Phí vận chuyển</span>
                                    <span class="fw-medium text-success"><?= $shipping > 0 ? formatPrice($shipping) : 'Miễn phí' ?></span>
                                </div>
                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-dark fs-5">Tổng cộng</span>
                                        <span class="fw-bold text-danger fs-3 lh-1"><?= formatPrice($total) ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-white d-none d-lg-block rounded-bottom-4">
                                <button type="submit" form="checkoutForm" class="btn btn-primary btn-lg w-100 rounded-pill d-flex justify-content-center align-items-center gap-2 shadow fw-bold" id="placeOrderBtn">
                                    <span class="material-symbols-rounded fs-5">lock</span> Đặt hàng
                                </button>
                                <p class="text-center text-muted small mb-0 mt-3"><span class="material-symbols-rounded fs-6 align-text-bottom text-primary">gpp_good</span> Thông tin của bạn được bảo mật tuyệt đối</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    let ok = true;
    const checks = [
        ['full_name','nameErr','Họ tên là bắt buộc.'],
        ['phone','phoneErr','Số điện thoại không hợp lệ.'],
        ['email','emailErr','Email không hợp lệ.'],
        ['province','provErr','Vui lòng chọn tỉnh/thành.'],
        ['district','distErr','Vui lòng nhập quận/huyện.'],
        ['address','addrErr','Địa chỉ là bắt buộc.'],
    ];
    checks.forEach(([fid, eid, msg]) => {
        const f = document.getElementById(fid), er = document.getElementById(eid);
        if (f && er) { 
            if (!f.value.trim()) { 
                er.textContent = msg; 
                f.classList.add('is-invalid');
                ok = false; 
            } else {
                er.textContent = ''; 
                f.classList.remove('is-invalid');
            }
        }
    });
    
    const phoneF = document.getElementById('phone');
    const phoneVal = phoneF.value.trim();
    if (phoneVal && !/^\d{9,12}$/.test(phoneVal)) {
        document.getElementById('phoneErr').textContent = 'Số điện thoại phải từ 9–12 chữ số.'; 
        phoneF.classList.add('is-invalid');
        ok = false;
    }
    
    const emailF = document.getElementById('email');
    const emailVal = emailF.value.trim();
    if (emailVal && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
        document.getElementById('emailErr').textContent = 'Email không hợp lệ.'; 
        emailF.classList.add('is-invalid');
        ok = false;
    }
    
    if (!ok) {
        e.preventDefault();
        // Cuộn màn hình lên trường bị lỗi đầu tiên
        const firstError = document.querySelector('.is-invalid');
        if(firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    } else {
        const btns = [document.getElementById('placeOrderBtn'), document.getElementById('placeOrderBtnMobile')];
        btns.forEach(btn => {
            if(btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';
            }
        });
    }
});
</script>
