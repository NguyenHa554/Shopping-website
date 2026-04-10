<?php // Admin contact detail — Expects: $contact ?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Chi tiết liên hệ #<?= (int)$contact['id'] ?></h5>
                    <a href="<?= BASE_URL ?>/admin/contacts" class="btn btn-outline-secondary">Quay lại</a>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4"><strong>Họ tên:</strong><br><?= e($contact['full_name']) ?></div>
                    <div class="col-md-4"><strong>Email:</strong><br><?= e($contact['email']) ?></div>
                    <div class="col-md-4"><strong>SĐT:</strong><br><?= e($contact['phone'] ?: '-') ?></div>
                    <div class="col-md-6"><strong>Chủ đề:</strong><br><?= e($contact['subject'] ?: '(Không có)') ?></div>
                    <div class="col-md-3"><strong>Trạng thái:</strong><br><span class="badge <?= $contact['status'] === 'unread' ? 'bg-danger' : ($contact['status'] === 'replied' ? 'bg-success' : 'bg-secondary') ?>"><?= e($contact['status']) ?></span></div>
                    <div class="col-md-3"><strong>Ngày gửi:</strong><br><?= formatDate($contact['created_at'], 'd/m/Y H:i') ?></div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Nội dung liên hệ</label>
                    <div class="border rounded p-3 bg-light"><?= nl2br(e($contact['message'])) ?></div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <form action="<?= BASE_URL ?>/admin/contacts/status/<?= (int)$contact['id'] ?>" method="POST" class="d-flex gap-2 align-items-center">
                        <?= csrfField() ?>
                        <select name="status" class="form-control" style="width:180px;">
                            <?php foreach (['unread', 'read', 'replied'] as $s): ?>
                                <option value="<?= $s ?>" <?= $contact['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                    </form>

                    <form action="<?= BASE_URL ?>/admin/contacts/delete/<?= (int)$contact['id'] ?>" method="POST" onsubmit="return confirm('Xóa liên hệ này?')">
                        <?= csrfField() ?>
                        <button type="submit" class="btn btn-outline-danger">Xóa liên hệ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
