<?php
// Login view
$form = $_SESSION['form'] ?? null;
unset($_SESSION['form']);
?>
<section class="auth-section">
    <div class="auth-card">
        <div class="auth-header">
            <a href="<?= url() ?>" class="logo">SONNE</a>
            <h1>Đăng nhập</h1>
            <p>Chào mừng trở lại!</p>
        </div>

        <form action="<?= url('login') ?>" method="POST" id="loginForm" novalidate>
            <?= csrfField() ?>

            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" class="form-control"
                       value="<?= e($_GET['email'] ?? '') ?>"
                       placeholder="email@example.com" required autocomplete="email">
                <span class="field-error" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu <span class="required">*</span></label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control"
                           placeholder="Nhập mật khẩu" required autocomplete="current-password">
                    <button type="button" class="toggle-pass" data-target="password">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
                <span class="field-error" id="passError"></span>
            </div>

            <div class="form-row form-row-between">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember"> Nhớ đăng nhập
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block" id="loginBtn">
                <i class="fa fa-sign-in-alt"></i> Đăng nhập
            </button>
        </form>

        <div class="auth-footer">
            <p>Chưa có tài khoản? <a href="<?= url('register') ?>">Đăng ký ngay</a></p>
        </div>
    </div>
</section>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    let ok = true;
    const email = document.getElementById('email');
    const pass  = document.getElementById('password');
    document.getElementById('emailError').textContent = '';
    document.getElementById('passError').textContent  = '';

    if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        document.getElementById('emailError').textContent = 'Vui lòng nhập email hợp lệ.';
        ok = false;
    }
    if (pass.value.length < 6) {
        document.getElementById('passError').textContent = 'Mật khẩu tối thiểu 6 ký tự.';
        ok = false;
    }
    if (!ok) e.preventDefault();
});
// Toggle password visibility
document.querySelectorAll('.toggle-pass').forEach(btn => {
    btn.addEventListener('click', () => {
        const inp = document.getElementById(btn.dataset.target);
        inp.type = inp.type === 'password' ? 'text' : 'password';
        btn.querySelector('i').classList.toggle('fa-eye');
        btn.querySelector('i').classList.toggle('fa-eye-slash');
    });
});
</script>
