<?php
// User Profile view — Expects: $user, $orders, $pg
$sl = ['pending'=>'Chờ xác nhận','processing'=>'Đang xử lý','shipped'=>'Đang giao','delivered'=>'Đã giao','cancelled'=>'Đã hủy'];
?>
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row g-4 g-lg-5">

            <!-- Sidebar -->
            <div class="col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 2rem;">
                    <div class="card-body p-4 text-center">
                        <div class="position-relative d-inline-block border border-3 border-white shadow-sm rounded-circle mb-3 bg-white" style="width: 120px; height: 120px;">
                            <?php if ($user['avatar']): ?>
                            <img src="<?= asset(e($user['avatar'])) ?>" alt="Avatar" class="w-100 h-100 object-fit-cover rounded-circle" id="avatarImg">
                            <?php else: ?>
                            <div class="w-100 h-100 bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary">
                                <span class="material-symbols-rounded" style="font-size: 60px;">person</span>
                            </div>
                            <?php endif; ?>
                            <form action="<?= url('profile/avatar') ?>" method="POST" enctype="multipart/form-data" id="avatarForm" class="position-absolute bottom-0 end-0">
                                <?= csrfField() ?>
                                <label for="avatarInput" class="btn btn-primary rounded-circle p-2 shadow d-flex align-items-center justify-content-center cursor-pointer" style="width: 36px; height: 36px; margin-bottom: 4px; margin-right: 4px;">
                                    <span class="material-symbols-rounded fs-6 text-white m-0">photo_camera</span>
                                </label>
                                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none" onchange="this.form.submit()">
                            </form>
                        </div>
                        <h2 class="h5 fw-bold text-dark mb-1"><?= e($user['full_name']) ?></h2>
                        <p class="text-muted small mb-4 d-flex align-items-center justify-content-center gap-1">
                            <span class="material-symbols-rounded fs-6">mail</span> <?= e($user['email']) ?>
                        </p>

                        <div class="list-group list-group-flush text-start border-top pt-3" role="tablist">
                            <a href="#panel-info" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 bg-transparent d-flex align-items-center gap-3 fw-medium active" data-bs-toggle="list" role="tab">
                                <span class="material-symbols-rounded fs-5 text-muted">person</span> Thông tin cá nhân
                            </a>
                            <a href="#panel-password" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 bg-transparent d-flex align-items-center gap-3 fw-medium" data-bs-toggle="list" role="tab">
                                <span class="material-symbols-rounded fs-5 text-muted">lock</span> Đổi mật khẩu
                            </a>
                            <a href="<?= url('orders') ?>" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 bg-transparent d-flex align-items-center justify-content-between fw-medium">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="material-symbols-rounded fs-5 text-muted">inventory_2</span> Đơn hàng của tôi
                                </div>
                                <?php if (!empty($orders)): ?>
                                <span class="badge bg-primary rounded-pill"><?= count($orders) ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="<?= url('wishlist') ?>" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 bg-transparent d-flex align-items-center gap-3 fw-medium">
                                <span class="material-symbols-rounded fs-5 text-muted">favorite</span> Sản phẩm yêu thích
                            </a>
                            <a href="<?= url('logout') ?>" class="list-group-item list-group-item-action border-0 rounded-3 mt-3 text-danger bg-danger bg-opacity-10 d-flex align-items-center gap-3 fw-medium">
                                <span class="material-symbols-rounded fs-5">logout</span> Đăng xuất
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main panels -->
            <div class="col-lg-8 col-xl-9">
                <div class="tab-content">
                    
                    <!-- Info tab -->
                    <div class="tab-pane fade show active" id="panel-info" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white border-bottom p-4">
                                <h3 class="h5 fw-bold mb-0">Hồ sơ của tôi</h3>
                                <p class="text-muted small mb-0 mt-1">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
                            </div>
                            <div class="card-body p-4 p-md-5">
                                <form action="<?= url('profile/update') ?>" method="POST" id="profileForm" novalidate>
                                    <?= csrfField() ?>
                                    
                                    <div class="row mb-4">
                                        <label for="full_name" class="col-sm-3 col-form-label fw-medium text-dark text-sm-end">Họ và tên <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="full_name" name="full_name" class="form-control form-control-lg bg-light border-0 shadow-sm" value="<?= e($user['full_name']) ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <label for="email" class="col-sm-3 col-form-label fw-medium text-dark text-sm-end">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" id="email" class="form-control form-control-lg bg-light border-0 shadow-sm text-muted" value="<?= e($user['email']) ?>" disabled readonly>
                                            <div class="form-text mt-2"><span class="material-symbols-rounded text-info fs-6 align-text-bottom">info</span> Email không thể thay đổi để đảm bảo bảo mật.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <label for="phone" class="col-sm-3 col-form-label fw-medium text-dark text-sm-end">Số điện thoại</label>
                                        <div class="col-sm-9">
                                            <input type="tel" id="phone" name="phone" class="form-control form-control-lg bg-light border-0 shadow-sm" value="<?= e($user['phone'] ?? '') ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <label for="address" class="col-sm-3 col-form-label fw-medium text-dark text-sm-end">Địa chỉ</label>
                                        <div class="col-sm-9">
                                            <textarea id="address" name="address" class="form-control form-control-lg bg-light border-0 shadow-sm" rows="3"><?= e($user['address'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-medium shadow-sm">Lưu thay đổi</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Password tab -->
                    <div class="tab-pane fade" id="panel-password" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white border-bottom p-4">
                                <h3 class="h5 fw-bold mb-0">Đổi Mật Khẩu</h3>
                                <p class="text-muted small mb-0 mt-1">Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác</p>
                            </div>
                            <div class="card-body p-4 p-md-5">
                                <form action="<?= url('profile/password') ?>" method="POST" id="passwordForm" novalidate>
                                    <?= csrfField() ?>
                                    
                                    <div class="row mb-4">
                                        <label for="current_password" class="col-sm-4 col-md-3 col-form-label fw-medium text-dark text-sm-end">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="password" id="current_password" name="current_password" class="form-control form-control-lg bg-light border-0 shadow-sm" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <label for="new_password" class="col-sm-4 col-md-3 col-form-label fw-medium text-dark text-sm-end">Mật khẩu mới <span class="text-danger">*</span></label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="password" id="new_password" name="new_password" class="form-control form-control-lg bg-light border-0 shadow-sm" required minlength="8">
                                            <div class="form-text mt-2">Mật khẩu phải dài ít nhất 8 ký tự.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <label for="confirm_password" class="col-sm-4 col-md-3 col-form-label fw-medium text-dark text-sm-end">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg bg-light border-0 shadow-sm" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-8 col-md-9 offset-sm-4 offset-md-3">
                                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-medium shadow-sm">Xác nhận đổi mật khẩu</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</section>

<script>
// Tab styling update on click to ensure symbols change state if needed
document.querySelectorAll('.list-group-item[data-bs-toggle="list"]').forEach(el => {
    el.addEventListener('shown.bs.tab', function (e) {
        document.querySelectorAll('.list-group-item .material-symbols-rounded').forEach(icon => icon.classList.add('text-muted'));
        document.querySelectorAll('.list-group-item.active .material-symbols-rounded').forEach(icon => icon.classList.remove('text-muted'));
    })
});

// Initial tab active state color
document.querySelectorAll('.list-group-item.active .material-symbols-rounded').forEach(icon => icon.classList.remove('text-muted'));

// Password validation
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const np = document.getElementById('new_password');
    const cp = document.getElementById('confirm_password');
    const b = this.querySelector('button[type="submit"]');
    
    np.classList.remove('is-invalid');
    cp.classList.remove('is-invalid');
    let ok = true;
    
    if (np.value.length < 8) { 
        np.classList.add('is-invalid');
        if(typeof showToast === 'function') { showToast('Mật khẩu mới phải ít nhất 8 ký tự.', 'error'); }
        else { alert('Mật khẩu mới phải ít nhất 8 ký tự.'); }
        ok = false;
    } else if (np.value !== cp.value) { 
        cp.classList.add('is-invalid');
        if(typeof showToast === 'function') { showToast('Xác nhận mật khẩu không khớp.', 'error'); }
        else { alert('Xác nhận mật khẩu không khớp.'); }
        ok = false;
    }
    
    if(!ok) {
        e.preventDefault();
    } else {
        b.disabled = true;
        b.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';
    }
});
</script>
