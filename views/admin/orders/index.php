<?php // Admin orders list — Expects: $orders, $pg, $status ?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Quản lý đơn hàng</h5>
        </div>

        <div class="card">
            <div class="card-body">

                <!-- Status filter tabs -->
                <div class="mb-3">
                    <?php
                    $statuses = [
                        ''           => 'Tất cả',
                        'pending'    => 'Chờ xác nhận',
                        'processing' => 'Đang xử lý',
                        'shipped'    => 'Đang giao',
                        'delivered'  => 'Đã giao',
                        'cancelled'  => 'Đã hủy',
                    ];
                    foreach ($statuses as $s => $label):
                    ?>
                    <a href="<?= BASE_URL ?>/admin/orders<?= $s ? '?status=' . $s : '' ?>"
                       class="btn btn-sm me-1 mb-1 <?= ($status??'') === $s ? 'btn-primary' : 'btn-outline-secondary' ?>">
                        <?= $label ?>
                    </a>
                    <?php endforeach; ?>
                </div>

                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-uppercase bg-dark">
                                <tr class="text-white">
                                    <th scope="col">Đơn</th>
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col" class="text-end">Tổng tiền</th>
                                    <th scope="col">Thanh toán</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ngày</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($orders as $o): ?>
                            <tr>
                                <td>
                                    <a href="<?= BASE_URL ?>/admin/orders/<?= (int)$o['id'] ?>" class="fw-bold">
                                        #<?= str_pad((int)$o['id'], 6, '0', STR_PAD_LEFT) ?>
                                    </a>
                                </td>
                                <td>
                                    <?= e($o['full_name']) ?>
                                    <br><small class="text-muted"><?= e($o['email']) ?></small>
                                </td>
                                <td><small class="text-muted"><?= e(mb_substr($o['address'], 0, 50)) ?>…</small></td>
                                <td class="text-end fw-semibold"><?= formatPrice((float)$o['total']) ?></td>
                                <td>
                                    <?= match($o['payment_method']) {
                                        'cod'          => 'COD',
                                        'bank_transfer' => 'Chuyển khoản',
                                        'credit_card'  => 'Thẻ',
                                        default        => e($o['payment_method'])
                                    } ?>
                                </td>
                                <td>
                                    <?php
                                    $badgeMap = [
                                        'pending'    => 'bg-warning text-dark',
                                        'processing' => 'bg-info text-dark',
                                        'shipped'    => 'bg-primary',
                                        'delivered'  => 'bg-success',
                                        'cancelled'  => 'bg-danger',
                                    ];
                                    $badgeClass = $badgeMap[$o['status']] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>">
                                        <?= e($o['status']) ?>
                                    </span>
                                </td>
                                <td><small><?= formatDate($o['created_at'], 'd/m/Y') ?></small></td>
                                <td>
                                    <a href="<?= BASE_URL ?>/admin/orders/<?= (int)$o['id'] ?>"
                                       class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>

            </div>
        </div>
    </div>
</div>
