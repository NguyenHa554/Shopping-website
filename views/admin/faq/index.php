<?php // Admin FAQ list — Expects: $faqs ?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Quản lý FAQ</h5>
            <a href="<?= BASE_URL ?>/admin/faq/create" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Thêm FAQ</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-uppercase bg-primary">
                            <tr class="text-white">
                                <th>ID</th>
                                <th>Câu hỏi</th>
                                <th>Thứ tự</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($faqs as $f): ?>
                            <tr>
                                <td><?= (int)$f['id'] ?></td>
                                <td>
                                    <div class="fw-semibold"><?= e($f['question']) ?></div>
                                    <small class="text-muted"><?= e(truncate($f['answer'], 120)) ?></small>
                                </td>
                                <td><?= (int)$f['sort_order'] ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>/admin/faq/edit/<?= (int)$f['id'] ?>" class="btn btn-sm btn-outline-primary me-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="<?= BASE_URL ?>/admin/faq/delete/<?= (int)$f['id'] ?>" method="POST" style="display:inline" onsubmit="return confirm('Xóa FAQ này?')">
                                        <?= csrfField() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($faqs)): ?>
                            <tr><td colspan="4" class="text-center">Chưa có FAQ.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
