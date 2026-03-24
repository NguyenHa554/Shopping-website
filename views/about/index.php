<?php
// About view — Expects: $pageContent
$intro   = $pageContent['about_intro']['content'] ?? '';
$mission = $pageContent['about_mission']['content'] ?? '';
?>
<section class="page-hero">
    <div class="container">
        <h1>Về SONNE</h1>
        <nav class="breadcrumb"><a href="<?= url() ?>">Trang chủ</a><span>/</span><span>Giới thiệu</span></nav>
    </div>
</section>
<section class="section about-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-text">
                <h2><?= e($pageContent['about_intro']['title'] ?? 'About SONNE') ?></h2>
                <p><?= nl2br(e($intro)) ?></p>
                <h3><?= e($pageContent['about_mission']['title'] ?? 'Our Mission') ?></h3>
                <p><?= nl2br(e($mission)) ?></p>
                <div class="about-stats">
                    <div class="stat"><span class="stat-num">2019</span><span>Thành lập</span></div>
                    <div class="stat"><span class="stat-num">50+</span><span>Sản phẩm</span></div>
                    <div class="stat"><span class="stat-num">100K+</span><span>Khách hàng</span></div>
                    <div class="stat"><span class="stat-num">100%</span><span>Cruelty Free</span></div>
                </div>
            </div>
            <div class="about-visual">
                <?php $img = $pageContent['about_intro']['image'] ?? null; ?>
                <?php if ($img): ?>
                <img src="<?= asset(e($img)) ?>" alt="SONNE Brand" loading="lazy">
                <?php else: ?>
                <div class="about-img-placeholder">
                    <div class="logo-large">SONNE</div>
                    <p>Premium Beauty Since 2019</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<section class="section brand-promise">
    <div class="container">
        <h2 class="text-center">Cam kết của chúng tôi</h2>
        <div class="promise-grid">
            <div class="promise-item"><i class="fa fa-leaf"></i><h3>Cruelty Free</h3><p>Không thử nghiệm trên động vật</p></div>
            <div class="promise-item"><i class="fa fa-seedling"></i><h3>Bền vững</h3><p>Bao bì tái chế, thân thiện môi trường</p></div>
            <div class="promise-item"><i class="fa fa-flask"></i><h3>Kiểm định da liễu</h3><p>Được kiểm chứng bởi chuyên gia da liễu</p></div>
            <div class="promise-item"><i class="fa fa-heart"></i><h3>Thành phần an toàn</h3><p>Không paraben, không SLS</p></div>
        </div>
    </div>
</section>
