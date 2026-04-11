<?php
$heroTitle = $pageContent['seller_hero']['title'] ?? 'Đăng ký trở thành nhà bán hàng';
$heroText  = $pageContent['seller_hero']['content'] ?? 'Gia nhập hệ sinh thái SONNE để tiếp cận hàng ngàn khách hàng mỗi ngày.';
?>
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-4">
        <h1 class="display-5 fw-bold mb-3"><?= e($heroTitle) ?></h1>
        <p class="lead mb-0"><?= e($heroText) ?></p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="h4 fw-bold mb-3">Thông tin đăng ký</h2>
                        <p class="text-muted">Trang này là giao diện mô phỏng cho bài tập lớn. Bạn có thể mở rộng thành quy trình duyệt nhà bán hàng đầy đủ.</p>
                        <form onsubmit="event.preventDefault(); alert('Đã ghi nhận thông tin đăng ký (demo).');">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tên shop</label>
                                    <input class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email liên hệ</label>
                                    <input type="email" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Số điện thoại</label>
                                    <input class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Loại hình kinh doanh</label>
                                    <select class="form-control" required>
                                        <option value="">Chọn</option>
                                        <option>Doanh nghiệp</option>
                                        <option>Cá nhân</option>
                                        <option>Hộ kinh doanh</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Mô tả ngắn</label>
                                    <textarea class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3" type="submit">Gửi đăng ký</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
