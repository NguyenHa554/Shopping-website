<?php
$heroTitle = $pageContent['services_hero']['title'] ?? 'Dịch vụ của SONNE';
$heroText  = $pageContent['services_hero']['content'] ?? 'Giải pháp bán hàng, vận hành và chăm sóc khách hàng toàn diện cho doanh nghiệp và nhà bán lẻ.';
?>
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-4">
        <h1 class="display-5 fw-bold mb-3"><?= e($heroTitle) ?></h1>
        <p class="lead mb-0"><?= e($heroText) ?></p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold">Thiết lập gian hàng</h3>
                        <p class="text-muted mb-0">Hỗ trợ onboarding, chuẩn hóa sản phẩm, tối ưu danh mục và bộ nhận diện shop.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold">Marketing đa kênh</h3>
                        <p class="text-muted mb-0">Tích hợp chiến dịch theo mùa, flash sale, email remarketing và SEO nội dung.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold">Vận hành & hậu cần</h3>
                        <p class="text-muted mb-0">Quản lý đơn hàng, kiểm soát tồn kho và kết nối đối tác giao vận theo SLA.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
