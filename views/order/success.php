<?php
// Order Success view — Expects: $order (with $order['items'])
?>
<section class="section order-success-section">
    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <div class="success-circle"><i class="fa fa-check"></i></div>
            </div>
            <h1>Đặt hàng thành công! 🎉</h1>
            <p class="success-subtitle">Cảm ơn bạn đã mua sắm tại SONNE. Đơn hàng của bạn đã được xác nhận.</p>
            <div class="order-info-box">
                <div class="order-info-row">
                    <span>Mã đơn hàng:</span>
                    <strong>#<?= str_pad((int)$order['id'], 6, '0', STR_PAD_LEFT) ?></strong>
                </div>
                <div class="order-info-row">
                    <span>Ngày đặt:</span>
                    <span><?= formatDate($order['created_at'], 'd/m/Y H:i') ?></span>
                </div>
                <div class="order-info-row">
                    <span>Giao đến:</span>
                    <span><?= e($order['address']) ?></span>
                </div>
                <div class="order-info-row">
                    <span>Thanh toán:</span>
                    <span><?= match($order['payment_method']){
                        'cod' => 'Thanh toán khi nhận hàng',
                        'bank_transfer' => 'Chuyển khoản ngân hàng',
                        'credit_card' => 'Thẻ tín dụng',
                        default => e($order['payment_method'])
                    } ?></span>
                </div>
                <div class="order-info-row order-total-row">
                    <span>Tổng cộng:</span>
                    <strong class="order-total-amt"><?= formatPrice((float)$order['total']) ?></strong>
                </div>
            </div>

            <!-- Items summary -->
            <div class="success-items">
                <?php foreach ($order['items'] as $item): ?>
                <div class="success-item">
                    <?php if ($item['cover_image']): ?>
                    <img src="<?= asset(e($item['cover_image'])) ?>" alt="<?= e($item['product_name']) ?>">
                    <?php endif; ?>
                    <span><?= e($item['product_name']) ?> × <?= (int)$item['quantity'] ?></span>
                    <span><?= formatPrice((float)$item['price'] * (int)$item['quantity']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="success-actions">
                <a href="<?= url('orders') ?>" class="btn btn-primary">
                    <i class="fa fa-box"></i> Xem đơn hàng
                </a>
                <a href="<?= url('products') ?>" class="btn btn-ghost">
                    <i class="fa fa-shopping-bag"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</section>
