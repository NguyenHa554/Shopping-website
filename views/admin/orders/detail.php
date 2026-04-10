<?php // Admin order detail — Expects: $order ?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Chi tiết đơn #<?= str_pad((int)$order['id'], 6, '0', STR_PAD_LEFT) ?></h5>
            <a href="<?= BASE_URL ?>/admin/orders" class="btn btn-outline-secondary">Quay lại</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3">Sản phẩm trong đơn</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-end">Đơn giá</th>
                                        <th class="text-center">SL</th>
                                        <th class="text-end">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach (($order['items'] ?? []) as $it): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <?php if (!empty($it['cover_image'])): ?>
                                                    <img src="<?= asset(e($it['cover_image'])) ?>" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                                <?php endif; ?>
                                                <span><?= e($it['product_name']) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-end"><?= formatPrice((float)$it['price']) ?></td>
                                        <td class="text-center"><?= (int)$it['quantity'] ?></td>
                                        <td class="text-end fw-semibold"><?= formatPrice((float)$it['price'] * (int)$it['quantity']) ?></td>
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
                        <p class="mb-2"><strong>Họ tên:</strong> <?= e($order['full_name']) ?></p>
                        <p class="mb-2"><strong>Email:</strong> <?= e($order['email']) ?></p>
                        <p class="mb-2"><strong>SĐT:</strong> <?= e($order['phone']) ?></p>
                        <p class="mb-2"><strong>Địa chỉ:</strong> <?= e($order['address']) ?></p>
                        <p class="mb-0"><strong>Ghi chú:</strong> <?= e($order['note'] ?: '-') ?></p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="mb-3">Cập nhật trạng thái</h6>
                        <form action="<?= BASE_URL ?>/admin/orders/status/<?= (int)$order['id'] ?>" method="POST" class="d-flex flex-column gap-2">
                            <?= csrfField() ?>
                            <select class="form-control" name="status">
                                <?php foreach (['pending','processing','shipped','delivered','cancelled'] as $s): ?>
                                    <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-primary">Lưu trạng thái</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3">Tổng kết</h6>
                        <div class="d-flex justify-content-between mb-2"><span>Tạm tính</span><span><?= formatPrice((float)$order['subtotal']) ?></span></div>
                        <div class="d-flex justify-content-between mb-2"><span>Vận chuyển</span><span><?= formatPrice((float)$order['shipping_fee']) ?></span></div>
                        <div class="d-flex justify-content-between fw-bold fs-5 border-top pt-2"><span>Tổng</span><span class="text-primary"><?= formatPrice((float)$order['total']) ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
