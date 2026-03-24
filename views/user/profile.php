<?php
// User Profile view — Expects: $user, $orders, $pg
$sl = ['pending'=>'Chờ xác nhận','processing'=>'Đang xử lý','shipped'=>'Đang giao','delivered'=>'Đã giao','cancelled'=>'Đã hủy'];
?>
<section class="section profile-section">
    <div class="container profile-layout">

        <!-- Sidebar -->
        <aside class="profile-sidebar">
            <div class="profile-avatar-wrap">
                <?php if ($user['avatar']): ?>
                <img src="<?= asset(e($user['avatar'])) ?>" alt="Avatar" class="profile-avatar" id="avatarImg">
                <?php else: ?>
                <div class="profile-avatar-placeholder"><i class="fa fa-user"></i></div>
                <?php endif; ?>
                <form action="<?= url('profile/avatar') ?>" method="POST" enctype="multipart/form-data" id="avatarForm">
                    <?= csrfField() ?>
                    <label for="avatarInput" class="avatar-change-btn"><i class="fa fa-camera"></i></label>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none"
                           onchange="this.form.submit()">
                </form>
            </div>
            <div class="profile-name"><?= e($user['full_name']) ?></div>
            <div class="profile-email"><i class="fa fa-envelope"></i> <?= e($user['email']) ?></div>
            <nav class="profile-nav">
                <a href="#info" class="profile-nav-link active" data-tab="info"><i class="fa fa-user"></i> Thông tin</a>
                <a href="#password" class="profile-nav-link" data-tab="password"><i class="fa fa-lock"></i> Mật khẩu</a>
                <a href="<?= url('orders') ?>"><i class="fa fa-box"></i> Đơn hàng
                    <?php if (!empty($orders)): ?>
                    <span class="badge" style="margin-left:4px;background:var(--primary)"><?= count($orders) ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?= url('wishlist') ?>"><i class="fa fa-heart"></i> Yêu thích</a>
                <a href="<?= url('logout') ?>"><i class="fa fa-sign-out-alt"></i> Đăng xuất</a>
            </nav>
        </aside>

        <!-- Main panels -->
        <div class="profile-main">
            <!-- Info tab -->
            <div class="profile-panel active" id="panel-info">
                <h2>Thông tin cá nhân</h2>
                <form action="<?= url('profile/update') ?>" method="POST" id="profileForm" novalidate>
                    <?= csrfField() ?>
                    <div class="form-group">
                        <label for="full_name">Họ và tên <span class="required">*</span></label>
                        <input type="text" id="full_name" name="full_name" class="form-control"
                               value="<?= e($user['full_name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" value="<?= e($user['email']) ?>" disabled>
                        <small class="hint">Email không thể thay đổi.</small>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" class="form-control"
                               value="<?= e($user['phone'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <textarea id="address" name="address" class="form-control" rows="2"><?= e($user['address'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>

            <!-- Password tab -->
            <div class="profile-panel" id="panel-password">
                <h2>Đổi mật khẩu</h2>
                <form action="<?= url('profile/password') ?>" method="POST" id="passwordForm" novalidate>
                    <?= csrfField() ?>
                    <div class="form-group">
                        <label for="current_password">Mật khẩu hiện tại <span class="required">*</span></label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Mật khẩu mới <span class="required">*</span></label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Xác nhận mật khẩu mới <span class="required">*</span></label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// Tab switching
document.querySelectorAll('.profile-nav-link[data-tab]').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        document.querySelectorAll('.profile-nav-link').forEach(l => l.classList.remove('active'));
        document.querySelectorAll('.profile-panel').forEach(p => p.classList.remove('active'));
        link.classList.add('active');
        document.getElementById('panel-' + link.dataset.tab).classList.add('active');
    });
});
// Password validation
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const np = document.getElementById('new_password').value;
    const cp = document.getElementById('confirm_password').value;
    if (np.length < 8) { alert('Mật khẩu mới phải ít nhất 8 ký tự.'); e.preventDefault(); }
    else if (np !== cp) { alert('Xác nhận mật khẩu không khớp.'); e.preventDefault(); }
});
</script>
