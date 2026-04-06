<?php // FAQ view — Expects: $faqs ?>
<section class="py-5 bg-dark text-white text-center position-relative background-cover" style="background-color: var(--primary);">
    <div class="container position-relative z-1 py-4 py-lg-5">
        <h1 class="display-4 fw-bold font-playfair mb-3">Hỏi &amp; Đáp</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= url() ?>" class="text-white text-decoration-none opacity-75 hover-opacity-100">Trang chủ</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Hỏi &amp; Đáp</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5 py-lg-5 bg-light min-vh-100">
    <div class="container py-lg-4" style="max-width: 800px;">
        <div class="text-center mb-5">
            <p class="lead text-muted">Tìm câu trả lời cho các câu hỏi thường gặp. Không tìm thấy? <a href="<?= url('contact') ?>" class="text-primary fw-medium text-decoration-none hover-opacity-75">Liên hệ chúng tôi</a>.</p>
        </div>
        
        <div class="accordion bg-white rounded-4 shadow-sm overflow-hidden p-3 p-md-4" id="faqAccordion">
            <?php foreach ($faqs as $i => $faq): ?>
            <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm">
                <h2 class="accordion-header" id="heading-<?= $i ?>">
                    <button class="accordion-button collapsed fw-bold py-3 px-4 bg-light text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $i ?>" aria-expanded="false" aria-controls="collapse-<?= $i ?>">
                        <?= e($faq['question']) ?>
                    </button>
                </h2>
                <div id="collapse-<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $i ?>" data-bs-parent="#faqAccordion">
                    <div class="accordion-body px-4 pb-4 pt-4 text-muted lh-lg bg-white border-top">
                        <?= nl2br(e($faq['answer'])) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
