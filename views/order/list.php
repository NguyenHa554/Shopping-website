<?php
// My Orders view — Expects: $orders, $pg, $empty
$statusLabels = [
    'pending'    => ['text' => 'Chờ xác nhận', 'class' => 'status-pending'],
    'processing' => ['text' => 'Đang xử lý',   'class' => 'status-processing'],
    'shipped'    => ['text' => 'Đang giao',     'class' => 'status-shipped'],
    'delivered'  => ['text' => 'Đã giao',       'class' => 'status-delivered'],
    'cancelled'  => ['text' => 'Đã hủy',        'class' => 'status-cancelled'],
];
?>
<section class="page-hero">
    <div class="container">
        <h1>Đơn hàng của tôi</h1>
        <nav class="breadcrumb"><a href="<?= url() ?>">Trang chủ</a><span>/</span><span>Đơn hàng</span></nav>
    </div>
</section>

<section class="section orders-section">
    <div class="container">
        <?php if ($empty): ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="fa fa-box-open"></i></div>
            <h2>Bạn chưa có đơn hàng nào</h2>
            <p>Hãy khám phá các sản phẩm tuyệt vời của SONNE!</p>
            <a href="<?= url('products') ?>" class="btn btn-primary">Mua sắm ngay</a>
        </div>
        <?php else: ?>
        <div class="orders-list">
            <?php foreach ($orders as $order):
                $sl = $statusLabels[$order['status']] ?? ['text' => $order['status'], 'class' => ''];
            ?>
            <div class="order-card">
                <div class="order-card-header">
                    <div>
                        <span class="order-number">Đơn hàng #<?= str_pad((int)$order['id'], 6, '0', STR_PAD_LEFT) ?></span>
                        <span class="order-date"><?= formatDate($order['created_at'], 'd/m/Y H:i') ?></span>
                    </div>
                    <span class="order-status <?= $sl['class'] ?>"><?= e($sl['text']) ?></span>
                </div>
                <div class="order-card-body">
                    <div class="order-meta">
                        <span><i class="fa fa-map-marker-alt"></i> <?= e($order['address']) ?></span>
                        <span><i class="fa fa-credit-card"></i> <?= match($order['payment_method']){
                            'cod'=>'COD', 'bank_transfer'=>'Chuyển khoản', 'credit_card'=>'Thẻ tín dụng', default=>e($order['payment_method'])
                        } ?></span>
                    </div>
                    <div class="order-total-line">
                        Tổng cộng: <strong><?= formatPrice((float)$order['total']) ?></strong>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
        <?php endif; ?>
    </div>
</section>
