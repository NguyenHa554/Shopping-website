<?php
$statusLabels = [
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
            <h5 class="mb-0">Chi tiết giỏ hàng của <?= e($cart['full_name']) ?></h5>
            <a href="<?= BASE_URL ?>/admin/carts" class="btn btn-outline-secondary">Quay lại</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Sản phẩm trong giỏ</h6>
                            <span class="badge <?= $badgeMap[$cart['status']] ?? 'bg-secondary' ?>">
                                <?= e($statusLabels[$cart['status']] ?? $cart['status']) ?>
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-end">Đơn giá</th>
                                        <th class="text-center">SL</th>
                                        <th class="text-end">Tạm tính</th>
                                        <th class="text-center">Thêm vào</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach (($cart['items'] ?? []) as $item): ?>
                                    <?php $unitPrice = (float)($item['sale_price'] ?: $item['price']); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <?php if (!empty($item['cover_image'])): ?>
                                                    <img src="<?= asset(e($item['cover_image'])) ?>" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                                <?php endif; ?>
                                                <div>
                                                    <a href="<?= BASE_URL ?>/product/<?= e($item['slug']) ?>" target="_blank" class="fw-semibold">
                                                        <?= e($item['name']) ?>
                                                    </a>
                                                    <div><small class="text-muted">Tồn kho: <?= (int)$item['stock'] ?></small></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end"><?= formatPrice($unitPrice) ?></td>
                                        <td class="text-center"><?= (int)$item['quantity'] ?></td>
                                        <td class="text-end fw-semibold"><?= formatPrice($unitPrice * (int)$item['quantity']) ?></td>
                                        <td class="text-center"><small><?= formatDate($item['added_at'], 'd/m/Y H:i') ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="mb-3">Thông tin khách hàng</h6>
                        <p class="mb-2"><strong>Họ tên:</strong> <?= e($cart['full_name']) ?></p>
                        <p class="mb-2"><strong>Email:</strong> <?= e($cart['email']) ?></p>
                        <p class="mb-2"><strong>SĐT:</strong> <?= e($cart['phone'] ?: '-') ?></p>
                        <p class="mb-0"><strong>Địa chỉ:</strong> <?= e($cart['address'] ?: '-') ?></p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="mb-3">Cập nhật trạng thái giỏ hàng</h6>
                        <form action="<?= BASE_URL ?>/admin/carts/status/<?= (int)$cart['user_id'] ?>" method="POST" class="d-flex flex-column gap-3">
                            <?= csrfField() ?>
                            <select class="form-control" name="status">
                                <?php foreach ($statusLabels as $value => $label): ?>
                                    <option value="<?= $value ?>" <?= $cart['status'] === $value ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                            <textarea class="form-control" name="note" rows="4" placeholder="Ghi chú xử lý giỏ hàng..."><?= e($cart['note'] ?? '') ?></textarea>
                            <button type="submit" class="btn btn-primary">Lưu trạng thái</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3">Tổng kết</h6>
                        <div class="d-flex justify-content-between mb-2"><span>Số mặt hàng</span><span><?= (int)$cart['product_count'] ?></span></div>
                        <div class="d-flex justify-content-between mb-2"><span>Tổng số lượng</span><span><?= (int)$cart['total_quantity'] ?></span></div>
                        <div class="d-flex justify-content-between mb-2"><span>Cập nhật cuối</span><span><?= formatDate($cart['last_added_at'], 'd/m/Y H:i') ?></span></div>
                        <div class="d-flex justify-content-between mb-2"><span>Đổi trạng thái</span><span><?= !empty($cart['status_updated_at']) ? formatDate($cart['status_updated_at'], 'd/m/Y H:i') : '-' ?></span></div>
                        <div class="d-flex justify-content-between fw-bold fs-5 border-top pt-2"><span>Giá trị giỏ</span><span class="text-primary"><?= formatPrice((float)$cart['total_value']) ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
