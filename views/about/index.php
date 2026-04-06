<?php
// About view — Expects: $pageContent
$intro   = $pageContent['about_intro']['content'] ?? '';
$mission = $pageContent['about_mission']['content'] ?? '';
?>
<!-- Page Hero -->
<section class="py-5 bg-dark text-white text-center position-relative background-cover" style="background-color: var(--primary);">
    <div class="container position-relative z-1 py-4 py-lg-5">
        <h1 class="display-4 fw-bold font-playfair mb-3">Về SONNE</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= url() ?>" class="text-white text-decoration-none opacity-75 hover-opacity-100">Trang chủ</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Giới thiệu</li>
            </ol>
        </nav>
    </div>
</section>

<!-- About Content -->
<section class="py-5 py-lg-5">
    <div class="container py-lg-4">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 order-2 order-lg-1">
                <h2 class="display-5 fw-bold font-playfair mb-4"><?= e($pageContent['about_intro']['title'] ?? 'Câu chuyện SONNE') ?></h2>
                <div class="lead text-muted mb-4 opacity-75 fs-6 lh-lg text-justify text-md-start">
                    <?= nl2br(e($intro)) ?>
                </div>
                
                <h3 class="h3 fw-bold font-playfair mt-5 mb-4 text-primary"><?= e($pageContent['about_mission']['title'] ?? 'Sứ mệnh') ?></h3>
                <div class="text-muted mb-5 lh-lg text-justify text-md-start">
                    <?= nl2br(e($mission)) ?>
                </div>
                
                <div class="row g-3 g-md-4 text-center">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center hover-shadow transition-all">
                            <span class="fs-3 fw-bold text-dark d-block font-playfair">2019</span>
                            <span class="fs-7 text-muted mt-2 text-uppercase tracking-wider fw-medium">Thành lập</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center hover-shadow transition-all">
                            <span class="fs-3 fw-bold text-dark d-block font-playfair">50+</span>
                            <span class="fs-7 text-muted mt-2 text-uppercase tracking-wider fw-medium">Sản phẩm</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center hover-shadow transition-all">
                            <span class="fs-3 fw-bold text-dark d-block font-playfair">100K+</span>
                            <span class="fs-7 text-muted mt-2 text-uppercase tracking-wider fw-medium">Khách hàng</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center hover-shadow transition-all">
                            <span class="fs-3 fw-bold text-dark d-block font-playfair">100%</span>
                            <span class="fs-7 text-muted mt-2 text-uppercase tracking-wider fw-medium">Cruelty Free</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="position-relative ps-lg-5">
                    <div class="rounded-5 overflow-hidden shadow-lg border border-4 border-white position-relative" style="aspect-ratio: 4/5;">
                        <?php $img = $pageContent['about_intro']['image'] ?? null; ?>
                        <?php if ($img): ?>
                        <img src="<?= asset(e($img)) ?>" alt="SONNE Brand" class="w-100 h-100 object-fit-cover transition-transform hover-scale" loading="lazy">
                        <?php else: ?>
                        <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center bg-secondary bg-opacity-10 text-secondary">
                            <span class="font-playfair display-1 fw-bold opacity-25">SONNE</span>
                            <p class="mt-3 letter-spacing-2 text-uppercase fs-6">Premium Beauty Since 2019</p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <!-- Decorative element, hidden on small screens -->
                    <div class="position-absolute bg-primary rounded-circle opacity-10 d-none d-lg-block z-n1" style="width: 300px; height: 300px; bottom: -50px; right: -50px;"></div>
                    <div class="position-absolute d-none d-lg-block" style="top: 30px; left: 10px; z-index: -1;">
                        <svg width="100" height="100" fill="none" viewBox="0 0 100 100">
                            <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <circle fill="var(--primary)" cx="2" cy="2" r="2" opacity="0.2"></circle>
                            </pattern>
                            <rect x="0" y="0" width="100" height="100" fill="url(#dots)"></rect>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Brand Promise -->
<section class="py-5 bg-light mb-auto">
    <div class="container py-lg-4">
        <div class="text-center mb-5">
            <span class="text-primary fw-bold tracking-wider text-uppercase small d-block mb-2">Giá trị cốt lõi</span>
            <h2 class="display-6 fw-bold font-playfair m-0">Cam kết của chúng tôi</h2>
        </div>
        
        <div class="row g-4 text-center">
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow transition-all bg-white py-4 px-3">
                    <div class="card-body">
                        <div class="d-inline-flex justify-content-center align-items-center bg-primary bg-opacity-10 text-primary rounded-circle mb-4" style="width: 80px; height: 80px;">
                            <span class="material-symbols-rounded" style="font-size: 40px;">cruelty_free</span>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Cruelty Free</h3>
                        <p class="text-muted mb-0">Không bao giờ thử nghiệm trên động vật.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow transition-all bg-white py-4 px-3">
                    <div class="card-body">
                        <div class="d-inline-flex justify-content-center align-items-center bg-success bg-opacity-10 text-success rounded-circle mb-4" style="width: 80px; height: 80px;">
                            <span class="material-symbols-rounded" style="font-size: 40px;">recycling</span>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Bền vững</h3>
                        <p class="text-muted mb-0">Bao bì có thể tái chế, tôn trọng môi trường.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow transition-all bg-white py-4 px-3">
                    <div class="card-body">
                        <div class="d-inline-flex justify-content-center align-items-center bg-info bg-opacity-10 text-info rounded-circle mb-4" style="width: 80px; height: 80px;">
                            <span class="material-symbols-rounded" style="font-size: 40px;">science</span>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Kiểm định da liễu</h3>
                        <p class="text-muted mb-0">Được phát triển và kiểm chứng bởi chuyên gia.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow transition-all bg-white py-4 px-3">
                    <div class="card-body">
                        <div class="d-inline-flex justify-content-center align-items-center bg-warning bg-opacity-10 text-warning rounded-circle mb-4" style="width: 80px; height: 80px;">
                            <span class="material-symbols-rounded" style="font-size: 40px;">verified</span>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Thành phần lành tính</h3>
                        <p class="text-muted mb-0">Công thức sạch, an toàn cho mọi loại da.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
