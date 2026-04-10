<?php
$heroTitle = $pageContent['pricing_hero']['title'] ?? 'Bảng giá dịch vụ';
$heroText  = $pageContent['pricing_hero']['content'] ?? 'Lựa chọn gói phù hợp cho quy mô kinh doanh của bạn.';
?>
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-4">
        <h1 class="display-5 fw-bold mb-3"><?= e($heroTitle) ?></h1>
        <p class="lead mb-0"><?= e($heroText) ?></p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold">Starter</h3>
                        <div class="display-6 fw-bold text-primary my-3">0 ₫</div>
                        <ul class="text-muted small mb-0">
                            <li>Tối đa 50 sản phẩm</li>
                            <li>1 tài khoản quản trị</li>
                            <li>Báo cáo cơ bản</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow rounded-4 h-100 border border-primary">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold">Business</h3>
                        <div class="display-6 fw-bold text-primary my-3">499.000 ₫/tháng</div>
                        <ul class="text-muted small mb-0">
                            <li>Không giới hạn sản phẩm</li>
                            <li>5 tài khoản quản trị</li>
                            <li>SEO + marketing tools</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold">Enterprise</h3>
                        <div class="display-6 fw-bold text-primary my-3">Liên hệ</div>
                        <ul class="text-muted small mb-0">
                            <li>Tư vấn riêng theo nghiệp vụ</li>
                            <li>Tích hợp API hệ thống</li>
                            <li>Hỗ trợ SLA 24/7</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
