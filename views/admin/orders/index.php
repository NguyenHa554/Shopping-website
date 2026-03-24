<?php // Admin orders list — Expects: $orders, $pg, $status ?>
<div class="admin-page">
    <div class="page-header"><h1>Quản lý đơn hàng</h1></div>
    <div class="admin-card">
        <div class="filter-tabs">
            <?php foreach ([''=>'Tất cả','pending'=>'Chờ xác nhận','processing'=>'Đang xử lý','shipped'=>'Đang giao','delivered'=>'Đã giao','cancelled'=>'Đã hủy'] as $s=>$label): ?>
            <a href="<?= BASE_URL ?>/admin/orders<?= $s ? '?status=' . $s : '' ?>"
               class="filter-tab <?= ($status??'') === $s ? 'active' : '' ?>"><?= $label ?></a>
            <?php endforeach; ?>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead><tr><th>Đơn</th><th>Khách hàng</th><th>Địa chỉ</th><th>Tổng</th><th>Phương thức TT</th><th>Trạng thái</th><th>Ngày</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td><a href="<?= BASE_URL ?>/admin/orders/<?= (int)$o['id'] ?>">#<?= str_pad((int)$o['id'],6,'0',STR_PAD_LEFT) ?></a></td>
                    <td><?= e($o['full_name']) ?><br><small><?= e($o['email']) ?></small></td>
                    <td><small><?= e(mb_substr($o['address'],0,50)) ?>…</small></td>
                    <td class="text-right"><?= formatPrice((float)$o['total']) ?></td>
                    <td><?= match($o['payment_method']){'cod'=>'COD','bank_transfer'=>'Chuyển khoản','credit_card'=>'Thẻ',default=>e($o['payment_method'])} ?></td>
                    <td><span class="status-badge status-<?= e($o['status']) ?>"><?= e($o['status']) ?></span></td>
                    <td><?= formatDate($o['created_at'],'d/m/Y') ?></td>
                    <td><a href="<?= BASE_URL ?>/admin/orders/<?= (int)$o['id'] ?>" class="btn btn-sm btn-outline"><i class="fa fa-eye"></i></a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
    </div>
</div>
