<?php // Admin contacts list — Expects: $contacts, $pg, $status ?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Quản lý liên hệ</h5>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <?php
                    $statuses = ['' => 'Tất cả', 'unread' => 'Chưa đọc', 'read' => 'Đã đọc', 'replied' => 'Đã phản hồi'];
                    foreach ($statuses as $s => $label):
                    ?>
                    <a href="<?= BASE_URL ?>/admin/contacts<?= $s ? '?status=' . $s : '' ?>" class="btn btn-sm me-1 mb-1 <?= ($status ?? '') === $s ? 'btn-primary' : 'btn-outline-secondary' ?>"><?= $label ?></a>
                    <?php endforeach; ?>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-uppercase bg-primary">
                            <tr class="text-white">
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Email</th>
                                <th>Chủ đề</th>
                                <th>Trạng thái</th>
                                <th>Ngày gửi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($contacts as $c): ?>
                            <tr>
                                <td><?= (int)$c['id'] ?></td>
                                <td><?= e($c['full_name']) ?><br><small class="text-muted"><?= e($c['phone'] ?? '-') ?></small></td>
                                <td><?= e($c['email']) ?></td>
                                <td><?= e($c['subject'] ?: '(Không có chủ đề)') ?></td>
                                <td><span class="badge <?= $c['status'] === 'unread' ? 'bg-danger' : ($c['status'] === 'replied' ? 'bg-success' : 'bg-secondary') ?>"><?= e($c['status']) ?></span></td>
                                <td><small><?= formatDate($c['created_at'], 'd/m/Y H:i') ?></small></td>
                                <td><a href="<?= BASE_URL ?>/admin/contacts/<?= (int)$c['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($contacts)): ?>
                            <tr><td colspan="7" class="text-center">Không có dữ liệu.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
            </div>
        </div>
    </div>
</div>
