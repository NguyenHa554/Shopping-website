<?php // Admin Dashboard view — Expects: $stats, $recentOrders ?>
<div class="admin-page">
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Chào mừng trở lại, <?= e($_SESSION['user']['full_name'] ?? 'Admin') ?>!</p>
    </div>

    <!-- Stats cards -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-icon"><i class="fa fa-box"></i></div>
            <div class="stat-info"><div class="stat-num"><?= number_format((int)$stats['products']) ?></div><div class="stat-label">Sản phẩm</div></div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon"><i class="fa fa-shopping-cart"></i></div>
            <div class="stat-info"><div class="stat-num"><?= number_format((int)$stats['orders']) ?></div><div class="stat-label">Đơn hàng</div></div>
        </div>
        <div class="stat-card purple">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
            <div class="stat-info"><div class="stat-num"><?= number_format((int)$stats['users']) ?></div><div class="stat-label">Thành viên</div></div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon"><i class="fa fa-money-bill-wave"></i></div>
            <div class="stat-info"><div class="stat-num"><?= number_format((float)$stats['revenue'], 0, ',', '.') ?> ₫</div><div class="stat-label">Doanh thu</div></div>
        </div>
        <div class="stat-card teal">
            <div class="stat-icon"><i class="fa fa-newspaper"></i></div>
            <div class="stat-info"><div class="stat-num"><?= (int)$stats['news'] ?></div><div class="stat-label">Bài viết</div></div>
        </div>
        <div class="stat-card red">
            <div class="stat-icon"><i class="fa fa-envelope"></i></div>
            <div class="stat-info"><div class="stat-num"><?= (int)$stats['contacts'] ?></div><div class="stat-label">Liên hệ mới</div></div>
        </div>
    </div>

    <!-- Recent orders table -->
    <div class="admin-card">
        <div class="card-head">
            <h2>Đơn hàng gần đây</h2>
            <a href="<?= BASE_URL ?>/admin/orders" class="btn btn-sm btn-outline">Xem tất cả</a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th><th>Khách hàng</th><th>Tổng tiền</th>
                        <th>Thanh toán</th><th>Trạng thái</th><th>Ngày</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($recentOrders as $o): ?>
                <tr>
                    <td><a href="<?= BASE_URL ?>/admin/orders/<?= (int)$o['id'] ?>">#<?= str_pad((int)$o['id'],6,'0',STR_PAD_LEFT) ?></a></td>
                    <td><?= e($o['full_name']) ?><br><small><?= e($o['email']) ?></small></td>
                    <td class="text-right"><?= number_format((float)$o['total'],0,',','.') ?> ₫</td>
                    <td><?= match($o['payment_method']){'cod'=>'COD','bank_transfer'=>'Chuyển khoản','credit_card'=>'Thẻ',default=>e($o['payment_method'])} ?></td>
                    <td><span class="status-badge status-<?= e($o['status']) ?>"><?= e($o['status']) ?></span></td>
                    <td><?= formatDate($o['created_at'],'d/m/Y') ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
