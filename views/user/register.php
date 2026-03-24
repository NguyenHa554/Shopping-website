<?php
// Register view
$form = $_SESSION['form'] ?? [];
unset($_SESSION['form']);
?>
<section class="auth-section">
    <div class="auth-card">
        <div class="auth-header">
            <a href="<?= url() ?>" class="logo">SONNE</a>
            <h1>Tạo tài khoản</h1>
            <p>Tham gia cộng đồng SONNE ngay hôm nay</p>
        </div>

        <form action="<?= url('register') ?>" method="POST" id="registerForm" novalidate>
            <?= csrfField() ?>

            <div class="form-group">
                <label for="full_name">Họ và tên <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name" class="form-control"
                       value="<?= e($form['name'] ?? '') ?>" placeholder="Nguyễn Văn A" required>
                <span class="field-error" id="nameError"></span>
            </div>

            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" class="form-control"
                       value="<?= e($form['email'] ?? '') ?>" placeholder="email@example.com" required>
                <span class="field-error" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="phone" name="phone" class="form-control"
                       value="<?= e($form['phone'] ?? '') ?>" placeholder="0901234567">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu <span class="required">*</span></label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control"
                           placeholder="Tối thiểu 8 ký tự" required>
                    <button type="button" class="toggle-pass" data-target="password"><i class="fa fa-eye"></i></button>
                </div>
                <span class="field-error" id="passError"></span>
            </div>

            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu <span class="required">*</span></label>
                <div class="input-group">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                           placeholder="Nhập lại mật khẩu" required>
                    <button type="button" class="toggle-pass" data-target="confirm_password"><i class="fa fa-eye"></i></button>
                </div>
                <span class="field-error" id="confirmError"></span>
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" id="agree" required>
                    Tôi đồng ý với <a href="<?= url('faq') ?>" target="_blank">điều khoản dịch vụ</a>
                </label>
                <span class="field-error" id="agreeError"></span>
            </div>

            <button type="submit" class="btn btn-primary btn-block" id="registerBtn">
                <i class="fa fa-user-plus"></i> Đăng ký
            </button>
        </form>

        <div class="auth-footer">
            <p>Đã có tài khoản? <a href="<?= url('login') ?>">Đăng nhập</a></p>
        </div>
    </div>
</section>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    let ok = true;
    const clearErrors = () => ['nameError','emailError','passError','confirmError','agreeError']
        .forEach(id => document.getElementById(id).textContent = '');
    clearErrors();

    const name    = document.getElementById('full_name').value.trim();
    const email   = document.getElementById('email').value.trim();
    const pass    = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;
    const agree   = document.getElementById('agree').checked;

    if (name.length < 2)  { document.getElementById('nameError').textContent = 'Họ tên tối thiểu 2 ký tự.'; ok = false; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { document.getElementById('emailError').textContent = 'Email không hợp lệ.'; ok = false; }
    if (pass.length < 8)  { document.getElementById('passError').textContent = 'Mật khẩu tối thiểu 8 ký tự.'; ok = false; }
    if (pass !== confirm) { document.getElementById('confirmError').textContent = 'Mật khẩu xác nhận không khớp.'; ok = false; }
    if (!agree)           { document.getElementById('agreeError').textContent = 'Vui lòng đồng ý điều khoản.'; ok = false; }
    if (!ok) e.preventDefault();
});
document.querySelectorAll('.toggle-pass').forEach(btn => {
    btn.addEventListener('click', () => {
        const inp = document.getElementById(btn.dataset.target);
        inp.type = inp.type === 'password' ? 'text' : 'password';
        btn.querySelector('i').classList.toggle('fa-eye');
        btn.querySelector('i').classList.toggle('fa-eye-slash');
    });
});
</script>
