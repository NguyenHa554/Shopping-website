<?php
// Contact view — Expects: $pageContent
$phone   = $pageContent['contact_phone']['title'] ?? '+84 28 3800 0000';
$email   = $pageContent['contact_email']['title'] ?? 'support@sonne.vn';
$address = $pageContent['contact_address']['title'] ?? 'Ho Chi Minh City, Vietnam';
?>
<!-- Page Hero -->
<section class="py-5 bg-dark text-white text-center position-relative background-cover" style="background-color: var(--primary);">
    <div class="container position-relative z-1 py-4 py-lg-5">
        <h1 class="display-4 fw-bold font-playfair mb-3">Liên hệ</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= url() ?>" class="text-white text-decoration-none opacity-75 hover-opacity-100">Trang chủ</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Liên hệ</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5 bg-light min-vh-100 flex-grow-1 d-flex flex-column">
    <div class="container py-lg-4 flex-grow-1">
        <div class="row g-5">
            <!-- Info -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="h3 fw-bold font-playfair mb-3">Kết nối với chúng tôi</h2>
                        <p class="text-muted mb-5">Đội ngũ SONNE luôn sẵn sàng hỗ trợ bạn. Phản hồi trong vòng 24 giờ.</p>
                        
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                <span class="material-symbols-rounded">call</span>
                            </div>
                            <div>
                                <span class="d-block text-muted small fw-medium text-uppercase tracking-wider">Điện thoại</span>
                                <span class="fw-bold text-dark fs-5"><?= e($phone) ?></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                <span class="material-symbols-rounded">mail</span>
                            </div>
                            <div>
                                <span class="d-block text-muted small fw-medium text-uppercase tracking-wider">Email</span>
                                <span class="fw-bold text-dark fs-5"><?= e($email) ?></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-5">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                <span class="material-symbols-rounded">location_on</span>
                            </div>
                            <div>
                                <span class="d-block text-muted small fw-medium text-uppercase tracking-wider">Địa chỉ</span>
                                <span class="fw-bold text-dark fs-6"><?= e($address) ?></span>
                            </div>
                        </div>

                        <hr class="my-5 border-secondary opacity-25">

                        <div>
                            <h4 class="h5 fw-bold d-flex align-items-center gap-2 mb-3">
                                <span class="material-symbols-rounded text-primary">schedule</span> Giờ làm việc
                            </h4>
                            <p class="mb-2 text-muted fw-medium d-flex justify-content-between align-items-center border-bottom pb-2">
                                <span>Thứ 2 – Thứ 6:</span>
                                <span class="text-dark">8:00 – 17:30</span>
                            </p>
                            <p class="mb-0 text-muted fw-medium d-flex justify-content-between align-items-center">
                                <span>Thứ 7:</span>
                                <span class="text-dark">8:00 – 12:00</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="h3 fw-bold font-playfair mb-4">Gửi tin nhắn</h2>
                        <form action="<?= url('contact') ?>" method="POST" id="contactForm" novalidate>
                            <?= csrfField() ?>
                            
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name" class="form-label fw-medium text-dark">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" id="full_name" name="full_name" class="form-control form-control-lg bg-light border-0 shadow-none px-3" required>
                                        <div class="invalid-feedback d-block fw-medium" id="cNameErr"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label fw-medium text-dark">Email <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control form-control-lg bg-light border-0 shadow-none px-3" required>
                                        <div class="invalid-feedback d-block fw-medium" id="cEmailErr"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label fw-medium text-dark">Số điện thoại</label>
                                        <input type="tel" id="phone" name="phone" class="form-control form-control-lg bg-light border-0 shadow-none px-3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject" class="form-label fw-medium text-dark">Chủ đề</label>
                                        <input type="text" id="subject" name="subject" class="form-control form-control-lg bg-light border-0 shadow-none px-3" placeholder="Chủ đề liên hệ...">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="message" class="form-label fw-medium text-dark">Nội dung <span class="text-danger">*</span></label>
                                <textarea id="message" name="message" class="form-control form-control-lg bg-light border-0 shadow-none px-3" rows="6" placeholder="Nội dung tin nhắn..." required></textarea>
                                <div class="invalid-feedback d-block fw-medium" id="cMsgErr"></div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 fw-bold tracking-wider d-flex align-items-center justify-content-center gap-2 shadow-sm text-uppercase">
                                <span class="material-symbols-rounded">send</span> Gửi tin nhắn
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    let ok = true;
    const nameF  = document.getElementById('full_name');
    const emailF = document.getElementById('email');
    const msgF   = document.getElementById('message');
    const btn    = this.querySelector('button[type="submit"]');

    const name  = nameF.value.trim();
    const email = emailF.value.trim();
    const msg   = msgF.value.trim();

    ['cNameErr','cEmailErr','cMsgErr'].forEach(id => document.getElementById(id).textContent = '');
    [nameF, emailF, msgF].forEach(f => f.classList.remove('is-invalid'));

    if (!name) { 
        document.getElementById('cNameErr').textContent = 'Vui lòng nhập họ tên.'; 
        nameF.classList.add('is-invalid');
        ok = false; 
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { 
        document.getElementById('cEmailErr').textContent = 'Email không hợp lệ.'; 
        emailF.classList.add('is-invalid');
        ok = false; 
    }
    if (!msg) { 
        document.getElementById('cMsgErr').textContent = 'Vui lòng nhập nội dung.'; 
        msgF.classList.add('is-invalid');
        ok = false; 
    }
    
    if (!ok) {
        e.preventDefault();
    } else {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';
    }
});
</script>
