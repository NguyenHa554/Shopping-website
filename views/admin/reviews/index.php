<?php // Admin reviews list — Expects: $reviews, $pg ?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Quản lý đánh giá sản phẩm</h5>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-uppercase bg-primary">
                            <tr class="text-white">
                                <th>ID</th>
                                <th>Sản phẩm</th>
                                <th>Người dùng</th>
                                <th>Điểm</th>
                                <th>Bình luận</th>
                                <th>Ngày</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($reviews as $r): ?>
                            <tr>
                                <td><?= (int)$r['id'] ?></td>
                                <td><?= e($r['product_name']) ?></td>
                                <td><?= e($r['full_name']) ?></td>
                                <td><span class="badge bg-warning text-dark"><?= (int)$r['rating'] ?>/5</span></td>
                                <td style="max-width:340px;"><?= e(truncate($r['comment'], 120)) ?></td>
                                <td><small><?= formatDate($r['created_at'], 'd/m/Y H:i') ?></small></td>
                                <td>
                                    <form action="<?= BASE_URL ?>/admin/reviews/delete/<?= (int)$r['id'] ?>" method="POST" onsubmit="return confirm('Xóa đánh giá này?')">
                                        <?= csrfField() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($reviews)): ?>
                            <tr><td colspan="7" class="text-center">Không có đánh giá.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
            </div>
        </div>
    </div>
</div>
