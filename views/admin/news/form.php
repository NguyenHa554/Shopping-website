<?php
$isEdit = !empty($article);
$action = $isEdit
    ? BASE_URL . '/admin/news/update/' . (int)$article['id']
    : BASE_URL . '/admin/news/store';
?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4"><?= $isEdit ? 'Sửa bài viết' : 'Thêm bài viết' ?></h4>

                <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <?= csrfField() ?>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required value="<?= e($article['title'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-control">
                                <?php $status = $article['status'] ?? 'published'; ?>
                                <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>published</option>
                                <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>draft</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Tóm tắt</label>
                            <textarea name="summary" rows="3" class="form-control"><?= e($article['summary'] ?? '') ?></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                            <textarea name="body" rows="10" class="form-control" required><?= e($article['body'] ?? '') ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ảnh bìa</label>
                            <input type="file" name="cover_image" class="form-control" accept="image/*">
                            <?php if ($isEdit && !empty($article['cover_image'])): ?>
                                <div class="mt-2">
                                    <img src="<?= asset(e($article['cover_image'])) ?>" alt="" class="img-thumbnail" style="max-height:120px;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Meta title</label>
                            <input type="text" name="meta_title" class="form-control" value="<?= e($article['meta_title'] ?? '') ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Meta description</label>
                            <textarea name="meta_description" rows="3" class="form-control"><?= e($article['meta_description'] ?? '') ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Meta keywords</label>
                            <textarea name="meta_keywords" rows="3" class="form-control" placeholder="keyword1, keyword2"><?= e($article['meta_keywords'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Lưu
                        </button>
                        <a href="<?= BASE_URL ?>/admin/news" class="btn btn-light border">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
