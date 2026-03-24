<?php // FAQ view — Expects: $faqs ?>
<section class="page-hero">
    <div class="container">
        <h1>Hỏi &amp; Đáp</h1>
        <nav class="breadcrumb"><a href="<?= url() ?>">Trang chủ</a><span>/</span><span>Hỏi &amp; Đáp</span></nav>
    </div>
</section>
<section class="section faq-section">
    <div class="container faq-container">
        <div class="faq-intro">
            <p>Tìm câu trả lời cho các câu hỏi thường gặp. Không tìm thấy? <a href="<?= url('contact') ?>">Liên hệ chúng tôi</a>.</p>
        </div>
        <div class="faq-list" id="faqList">
            <?php foreach ($faqs as $i => $faq): ?>
            <div class="faq-item" id="faq-<?= (int)$faq['id'] ?>">
                <button class="faq-question" aria-expanded="false" aria-controls="faq-ans-<?= $i ?>">
                    <span><?= e($faq['question']) ?></span>
                    <i class="fa fa-chevron-down faq-icon"></i>
                </button>
                <div class="faq-answer" id="faq-ans-<?= $i ?>" role="region">
                    <p><?= nl2br(e($faq['answer'])) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<script>
document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        document.querySelectorAll('.faq-question').forEach(b => {
            b.setAttribute('aria-expanded', 'false');
            b.closest('.faq-item').classList.remove('open');
        });
        if (!expanded) {
            btn.setAttribute('aria-expanded', 'true');
            btn.closest('.faq-item').classList.add('open');
        }
    });
});
</script>
