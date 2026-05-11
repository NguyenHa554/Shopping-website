<?php
$statusLabels = [
    '' => 'Tất cả',
    'active' => 'Đang hoạt động',
    'abandoned' => 'Bỏ dở',
    'contacted' => 'Đã liên hệ',
    'archived' => 'Lưu trữ',
];
$badgeMap = [
    'active' => 'bg-primary',
    'abandoned' => 'bg-warning text-dark',
    'contacted' => 'bg-info text-dark',
    'archived' => 'bg-secondary',
];
?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Quản lý giỏ hàng</h5>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-3">
                    <div>
                        <?php foreach ($statusLabels as $value => $label): ?>
                            <?php
                            $query = $value !== '' ? '?status=' . urlencode($value) : '';
                            if (!empty($search)) {
                                $query .= ($query ? '&' : '?') . 'q=' . urlencode($search);
                            }
                            ?>
                            <a href="<?= BASE_URL ?>/admin/carts<?= $query ?>"
                               class="btn btn-sm me-1 mb-1 <?= ($status ?? '') === $value ? 'btn-primary' : 'btn-outline-secondary' ?>">
                                <?= $label ?>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <form action="<?= BASE_URL ?>/admin/carts" method="GET" class="d-flex gap-2">
                        <?php if (!empty($status)): ?>
                            <input type="hidden" name="status" value="<?= e($status) ?>">
                        <?php endif; ?>
                        <input type="text" class="form-control" name="q" value="<?= e($search ?? '') ?>" placeholder="Tìm theo tên, email, số điện thoại">
                        <button type="submit" class="btn btn-dark text-nowrap">Tìm kiếm</button>
                    </form>
                </div>

                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="text-uppercase bg-dark">
                                <tr class="text-white">
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Liên hệ</th>
                                    <th scope="col" class="text-center">Mặt hàng</th>
                                    <th scope="col" class="text-center">Tổng SL</th>
                                    <th scope="col" class="text-end">Giá trị</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Cập nhật cuối</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($carts as $cart): ?>
                                <tr>
                                    <td class="fw-semibold"><?= e($cart['full_name']) ?></td>
                                    <td>
                                        <div><?= e($cart['email']) ?></div>
                                        <small class="text-muted"><?= e($cart['phone'] ?: '-') ?></small>
                                    </td>
                                    <td class="text-center"><?= (int)$cart['product_count'] ?></td>
                                    <td class="text-center"><?= (int)$cart['total_quantity'] ?></td>
                                    <td class="text-end fw-semibold"><?= formatPrice((float)$cart['total_value']) ?></td>
                                    <td>
                                        <?php $badgeClass = $badgeMap[$cart['status']] ?? 'bg-secondary'; ?>
                                        <span class="badge <?= $badgeClass ?>"><?= e($statusLabels[$cart['status']] ?? $cart['status']) ?></span>
                                    </td>
                                    <td><small><?= formatDate($cart['last_added_at'], 'd/m/Y H:i') ?></small></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/admin/carts/<?= (int)$cart['user_id'] ?>" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (!$carts): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Không có giỏ hàng phù hợp.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
            </div>
        </div>
    </div>
</div>
