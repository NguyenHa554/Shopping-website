<?php
$isEdit = !empty($faq);
$action = $isEdit
    ? BASE_URL . '/admin/faq/update/' . (int)$faq['id']
    : BASE_URL . '/admin/faq/store';
?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4"><?= $isEdit ? 'Sửa FAQ' : 'Thêm FAQ' ?></h4>

                <form action="<?= $action ?>" method="POST">
                    <?= csrfField() ?>

                    <div class="mb-3">
                        <label class="form-label">Câu hỏi <span class="text-danger">*</span></label>
                        <input type="text" name="question" class="form-control" required value="<?= e($faq['question'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Câu trả lời <span class="text-danger">*</span></label>
                        <textarea name="answer" rows="6" class="form-control" required><?= e($faq['answer'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4" style="max-width: 220px;">
                        <label class="form-label">Thứ tự hiển thị</label>
                        <input type="number" name="sort_order" class="form-control" value="<?= (int)($faq['sort_order'] ?? 0) ?>">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="<?= BASE_URL ?>/admin/faq" class="btn btn-light border">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
