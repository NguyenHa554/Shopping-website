<?php
// Contact view — Expects: $pageContent
$phone   = $pageContent['contact_phone']['title'] ?? '+84 28 3800 0000';
$email   = $pageContent['contact_email']['title'] ?? 'support@sonne.vn';
$address = $pageContent['contact_address']['title'] ?? 'Ho Chi Minh City, Vietnam';
?>
<section class="page-hero">
    <div class="container">
        <h1>Liên hệ</h1>
        <nav class="breadcrumb"><a href="<?= url() ?>">Trang chủ</a><span>/</span><span>Liên hệ</span></nav>
    </div>
</section>
<section class="section contact-section">
    <div class="container contact-layout">
        <!-- Info -->
        <div class="contact-info">
            <h2>Kết nối với chúng tôi</h2>
            <p>Đội ngũ SONNE luôn sẵn sàng hỗ trợ bạn. Phản hồi trong vòng 24 giờ.</p>
            <div class="contact-detail"><i class="fa fa-phone"></i><span><?= e($phone) ?></span></div>
            <div class="contact-detail"><i class="fa fa-envelope"></i><span><?= e($email) ?></span></div>
            <div class="contact-detail"><i class="fa fa-map-marker-alt"></i><span><?= e($address) ?></span></div>
            <div class="contact-hours">
                <h4><i class="fa fa-clock"></i> Giờ làm việc</h4>
                <p>Thứ 2 – Thứ 6: 8:00 – 17:30</p>
                <p>Thứ 7: 8:00 – 12:00</p>
            </div>
        </div>
        <!-- Form -->
        <div class="contact-form-wrap">
            <h2>Gửi tin nhắn</h2>
            <form action="<?= url('contact') ?>" method="POST" id="contactForm" novalidate>
                <?= csrfField() ?>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="full_name">Họ và tên <span class="required">*</span></label>
                        <input type="text" id="full_name" name="full_name" class="form-control" required>
                        <span class="field-error" id="cNameErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" required>
                        <span class="field-error" id="cEmailErr"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="subject">Chủ đề</label>
                    <input type="text" id="subject" name="subject" class="form-control" placeholder="Chủ đề liên hệ...">
                </div>
                <div class="form-group">
                    <label for="message">Nội dung <span class="required">*</span></label>
                    <textarea id="message" name="message" class="form-control" rows="5"
                              placeholder="Nội dung tin nhắn..." required></textarea>
                    <span class="field-error" id="cMsgErr"></span>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-paper-plane"></i> Gửi tin nhắn
                </button>
            </form>
        </div>
    </div>
</section>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    let ok = true;
    const name  = document.getElementById('full_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const msg   = document.getElementById('message').value.trim();
    ['cNameErr','cEmailErr','cMsgErr'].forEach(id => document.getElementById(id).textContent = '');
    if (!name) { document.getElementById('cNameErr').textContent = 'Vui lòng nhập họ tên.'; ok = false; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { document.getElementById('cEmailErr').textContent = 'Email không hợp lệ.'; ok = false; }
    if (!msg)  { document.getElementById('cMsgErr').textContent = 'Vui lòng nhập nội dung.'; ok = false; }
    if (!ok) e.preventDefault();
});
</script>
