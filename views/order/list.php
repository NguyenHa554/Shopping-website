<?php
// My Orders view — Expects: $orders, $pg, $empty
$statusLabels = [
    'pending'    => ['text' => 'Chờ xác nhận', 'class' => 'bg-warning text-dark'],
    'processing' => ['text' => 'Đang xử lý',   'class' => 'bg-info text-white'],
    'shipped'    => ['text' => 'Đang giao',     'class' => 'bg-primary text-white'],
    'delivered'  => ['text' => 'Đã giao',       'class' => 'bg-success text-white'],
    'cancelled'  => ['text' => 'Đã hủy',        'class' => 'bg-danger text-white'],
];
?>
<section class="py-5 bg-dark text-white text-center position-relative background-cover" style="background-color: var(--primary);">
    <div class="container position-relative z-1 py-4 py-lg-5">
        <h1 class="display-4 fw-bold font-playfair mb-3">Đơn hàng của tôi</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= url() ?>" class="text-white text-decoration-none opacity-75 hover-opacity-100">Trang chủ</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Đơn hàng</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5 bg-light min-vh-100 flex-grow-1">
    <div class="container py-lg-4" style="max-width: 900px;">
        <?php if ($empty): ?>
        <div class="text-center py-5 bg-white rounded-5 shadow-sm">
            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4 text-muted" style="width: 100px; height: 100px;">
                <span class="material-symbols-rounded" style="font-size: 48px;">inventory_2</span>
            </div>
            <h2 class="h4 fw-bold font-playfair mb-3">Bạn chưa có đơn hàng nào</h2>
            <p class="text-muted mb-4">Hãy khám phá các sản phẩm tuyệt vời của SONNE!</p>
            <a href="<?= url('products') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-medium d-inline-flex align-items-center gap-2">
                <span class="material-symbols-rounded">shopping_bag</span> Mua sắm ngay
            </a>
        </div>
        <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($orders as $order):
                $sl = $statusLabels[$order['status']] ?? ['text' => $order['status'], 'class' => 'bg-secondary text-white'];
            ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all w-100 bg-white">
                    <div class="card-header bg-white border-bottom p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <span class="d-block fw-bold text-dark fs-5 mb-1">Đơn hàng #<?= str_pad((int)$order['id'], 6, '0', STR_PAD_LEFT) ?></span>
                            <span class="text-muted small d-flex align-items-center gap-1">
                                <span class="material-symbols-rounded" style="font-size: 16px;">calendar_month</span> <?= formatDate($order['created_at'], 'd/m/Y H:i') ?>
                            </span>
                        </div>
                        <div>
                            <span class="badge <?= $sl['class'] ?> rounded-pill px-3 py-2 fw-medium border"><?= e($sl['text']) ?></span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4 align-items-center border-bottom pb-4 mb-4">
                            <div class="col-md-7">
                                <div class="d-flex gap-3 align-items-start mb-3 mb-md-0">
                                    <div class="text-primary bg-primary bg-opacity-10 rounded-circle p-2 mt-1">
                                        <span class="material-symbols-rounded">location_on</span>
                                    </div>
                                    <div>
                                        <span class="d-block tracking-wider text-uppercase small fw-bold text-muted mb-1">Địa chỉ giao hàng</span>
                                        <span class="text-dark fw-medium lh-base"><?= e($order['address']) ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="text-info bg-info bg-opacity-10 rounded-circle p-2 mt-1">
                                        <span class="material-symbols-rounded">payments</span>
                                    </div>
                                    <div>
                                        <span class="d-block tracking-wider text-uppercase small fw-bold text-muted mb-1">Phương thức thanh toán</span>
                                        <span class="text-dark fw-medium lh-base"><?= match($order['payment_method']){
                                            'cod'=>'Thanh toán khi nhận hàng (COD)', 'bank_transfer'=>'Chuyển khoản ngân hàng', 'credit_card'=>'Thẻ tín dụng', default=>e($order['payment_method'])
                                        } ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#" class="btn btn-outline-primary rounded-pill px-4 fw-medium text-decoration-none hover-shadow">Chi tiết đơn hàng</a>
                            <div class="text-end">
                                <span class="text-muted small fw-medium">Tổng cộng:</span>
                                <span class="d-block fs-4 fw-bold text-primary"><?= formatPrice((float)$order['total']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="d-flex justify-content-center">
            <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
