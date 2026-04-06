<?php
// Order Success view — Expects: $order (with $order['items'])
?>
<section class="py-5 bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container py-lg-4" style="max-width: 800px;">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden bg-white mt-4">
            <div class="card-body p-4 p-md-5 text-center">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle shadow-sm" style="width: 80px; height: 80px;">
                        <span class="material-symbols-rounded" style="font-size: 40px;">check_circle</span>
                    </div>
                </div>
                
                <h1 class="display-6 fw-bold font-playfair mb-3">Đặt hàng thành công! 🎉</h1>
                <p class="lead text-muted mb-5">Cảm ơn bạn đã mua sắm tại SONNE. Quý khách sẽ nhận được email xác nhận đơn hàng trong vài phút tới.</p>
                
                <div class="bg-light rounded-4 p-4 p-md-5 text-start mb-5 border">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <span class="d-block text-muted small fw-medium text-uppercase tracking-wider mb-1">Mã đơn hàng</span>
                            <strong class="fs-5 text-dark">#<?= str_pad((int)$order['id'], 6, '0', STR_PAD_LEFT) ?></strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="d-block text-muted small fw-medium text-uppercase tracking-wider mb-1">Ngày đặt</span>
                            <span class="fs-6 fw-medium text-dark"><?= formatDate($order['created_at'], 'd/m/Y H:i') ?></span>
                        </div>
                        <div class="col-sm-6">
                            <span class="d-block text-muted small fw-medium text-uppercase tracking-wider mb-1">Thanh toán</span>
                            <span class="fs-6 fw-medium text-dark"><?= match($order['payment_method']){
                                'cod' => 'Thanh toán khi nhận hàng',
                                'bank_transfer' => 'Chuyển khoản ngân hàng',
                                'credit_card' => 'Thẻ tín dụng',
                                default => e($order['payment_method'])
                            } ?></span>
                        </div>
                        <div class="col-sm-6">
                            <span class="d-block text-muted small fw-medium text-uppercase tracking-wider mb-1">Tổng cộng</span>
                            <strong class="fs-5 text-primary"><?= formatPrice((float)$order['total']) ?></strong>
                        </div>
                        <div class="col-12">
                            <span class="d-block text-muted small fw-medium text-uppercase tracking-wider mb-1">Giao đến</span>
                            <span class="fs-6 fw-medium text-dark lh-base"><?= e($order['address']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Items summary -->
                <div class="text-start mb-5">
                    <h3 class="h5 fw-bold font-playfair mb-4 border-bottom pb-3">Chi tiết sản phẩm</h3>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($order['items'] as $item): ?>
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0">
                                <?php if ($item['cover_image']): ?>
                                <img src="<?= asset(e($item['cover_image'])) ?>" alt="<?= e($item['product_name']) ?>" class="rounded-3 object-fit-cover shadow-sm bg-white border" width="60" height="60">
                                <?php else: ?>
                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center text-muted border" style="width: 60px; height: 60px;">
                                    <span class="material-symbols-rounded">image</span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="h6 fw-bold text-dark mb-1 text-truncate" style="max-width: 250px;"><?= e($item['product_name']) ?></h4>
                                <span class="text-muted small fw-medium">Số lượng: <?= (int)$item['quantity'] ?></span>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <span class="d-block fw-bold text-dark"><?= formatPrice((float)$item['price'] * (int)$item['quantity']) ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="<?= url('orders') ?>" class="btn btn-primary btn-lg rounded-pill px-4 fw-medium shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <span class="material-symbols-rounded">inventory_2</span> Xem đơn hàng
                    </a>
                    <a href="<?= url('products') ?>" class="btn btn-outline-dark btn-lg rounded-pill px-4 fw-medium d-flex align-items-center justify-content-center gap-2">
                        <span class="material-symbols-rounded">shopping_bag</span> Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
