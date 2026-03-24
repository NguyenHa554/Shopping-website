<?php
// Admin product form (create & edit) — Expects: $product (null for create), $categories
$isEdit = $product !== null;
$p      = $product ?? [];
?>
<div class="admin-page">
    <div class="page-header">
        <h1><?= $isEdit ? 'Sửa sản phẩm' : 'Thêm sản phẩm' ?></h1>
        <a href="<?= BASE_URL ?>/admin/products" class="btn btn-outline"><i class="fa fa-arrow-left"></i> Quay lại</a>
    </div>
    <div class="admin-card">
        <form action="<?= $isEdit ? BASE_URL . '/admin/products/update/' . (int)$p['id'] : BASE_URL . '/admin/products/store' ?>"
              method="POST" enctype="multipart/form-data">
            <?= csrfField() ?>
            <div class="form-grid-2">
                <div class="form-group">
                    <label>Tên sản phẩm <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control" value="<?= e($p['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Danh mục <span class="required">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <?php foreach ($categories as $c): ?>
                        <option value="<?= (int)$c['id'] ?>" <?= ($p['category_id'] ?? 0) == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Giá gốc (₫) <span class="required">*</span></label>
                    <input type="number" name="price" class="form-control" value="<?= e($p['price'] ?? '') ?>" min="0" step="1000" required>
                </div>
                <div class="form-group">
                    <label>Giá khuyến mãi (₫)</label>
                    <input type="number" name="sale_price" class="form-control" value="<?= e($p['sale_price'] ?? '') ?>" min="0" step="1000">
                </div>
                <div class="form-group">
                    <label>Số lượng kho <span class="required">*</span></label>
                    <input type="number" name="stock" class="form-control" value="<?= (int)($p['stock'] ?? 0) ?>" min="0" required>
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="active"   <?= ($p['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Hiển thị</option>
                        <option value="inactive" <?= ($p['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Mô tả sản phẩm</label>
                <textarea name="description" class="form-control" rows="6"><?= e($p['description'] ?? '') ?></textarea>
            </div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_featured" <?= ($p['is_featured'] ?? 0) ? 'checked' : '' ?>>
                        Sản phẩm nổi bật
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_flash_sale" <?= ($p['is_flash_sale'] ?? 0) ? 'checked' : '' ?>>
                        Flash Sale
                    </label>
                </div>
                <div class="form-group">
                    <label>Flash Sale kết thúc</label>
                    <input type="datetime-local" name="flash_ends_at" class="form-control"
                           value="<?= $p['flash_ends_at'] ? date('Y-m-d\TH:i', strtotime($p['flash_ends_at'])) : '' ?>">
                </div>
            </div>
            <div class="form-group">
                <label>Ảnh bìa</label>
                <?php if (!empty($p['cover_image'])): ?>
                <div class="current-img"><img src="<?= asset(e($p['cover_image'])) ?>" alt="cover" style="max-height:120px"></div>
                <?php endif; ?>
                <input type="file" name="cover_image" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label>Ảnh bổ sung (chọn nhiều)</label>
                <?php if (!empty($p['images'])): ?>
                <div class="extra-imgs">
                    <?php foreach ($p['images'] as $img): ?>
                    <img src="<?= asset(e($img['image_path'])) ?>" alt="img" style="max-height:80px;margin:4px">
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <input type="file" name="extra_images[]" class="form-control" accept="image/*" multiple>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> <?= $isEdit ? 'Lưu thay đổi' : 'Thêm sản phẩm' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/products" class="btn btn-ghost">Hủy</a>
            </div>
        </form>
    </div>
</div>
