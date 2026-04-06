<?php
// Login view
$form = $_SESSION['form'] ?? null;
unset($_SESSION['form']);
?>
<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5 col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <a href="<?= url() ?>" class="text-decoration-none text-dark d-inline-block mb-3">
                                <span class="fs-3 fw-bold font-playfair tracking-wider">SONNE</span>
                            </a>
                            <h1 class="h3 fw-bold mb-1">Đăng nhập</h1>
                            <p class="text-muted">Chào mừng trở lại!</p>
                        </div>

                        <form action="<?= url('login') ?>" method="POST" id="loginForm" novalidate>
                            <?= csrfField() ?>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium text-dark">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><span class="material-symbols-rounded fs-5">mail</span></span>
                                    <input type="email" id="email" name="email" class="form-control border-start-0 ps-0 shadow-none"
                                           value="<?= e($_GET['email'] ?? '') ?>"
                                           placeholder="email@example.com" required autocomplete="email">
                                </div>
                                <div class="invalid-feedback d-block fw-medium" id="emailError"></div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-medium text-dark">Mật khẩu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><span class="material-symbols-rounded fs-5">lock</span></span>
                                    <input type="password" id="password" name="password" class="form-control border-start-0 border-end-0 px-0 shadow-none"
                                           placeholder="Nhập mật khẩu" required autocomplete="current-password">
                                    <button type="button" class="input-group-text bg-white text-muted toggle-pass border-start-0 shadow-none hover-primary" data-target="password">
                                        <span class="material-symbols-rounded fs-5">visibility</span>
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block fw-medium" id="passError"></div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input border-secondary" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label text-secondary cursor-pointer select-none" for="remember">
                                        Nhớ đăng nhập
                                    </label>
                                </div>
                                <a href="#" class="text-primary text-decoration-none fw-medium small hover-opacity-75">Quên mật khẩu?</a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-medium shadow-sm d-flex justify-content-center align-items-center gap-2" id="loginBtn">
                                <span class="material-symbols-rounded fs-5">login</span> Đăng nhập
                            </button>
                        </form>
                    </div>
                    <div class="card-footer bg-white border-top text-center py-4">
                        <p class="text-secondary mb-0">Chưa có tài khoản? <a href="<?= url('register') ?>" class="text-primary text-decoration-none fw-bold hover-opacity-75">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
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
    email.classList.remove('is-invalid');
    pass.classList.remove('is-invalid');

    if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        document.getElementById('emailError').textContent = 'Vui lòng nhập email hợp lệ.';
        email.classList.add('is-invalid');
        ok = false;
    }
    if (pass.value.length < 6) {
        document.getElementById('passError').textContent = 'Mật khẩu tối thiểu 6 ký tự.';
        pass.classList.add('is-invalid');
        ok = false;
    }
    
    if (!ok) {
        e.preventDefault();
    } else {
        const btn = document.getElementById('loginBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';
    }
});
// Toggle password visibility
document.querySelectorAll('.toggle-pass').forEach(btn => {
    btn.addEventListener('click', () => {
        const inp = document.getElementById(btn.dataset.target);
        const icon = btn.querySelector('.material-symbols-rounded');
        inp.type = inp.type === 'password' ? 'text' : 'password';
        icon.textContent = inp.type === 'password' ? 'visibility' : 'visibility_off';
    });
});
</script>
