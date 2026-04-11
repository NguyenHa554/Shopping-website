<?php
// Admin product form (create & edit) — Expects: $product (null for create), $categories
$isEdit = $product !== null;
$p      = $product ?? [];
?>
<div class="row">
    <div class="col-12 mt-4">
        <!-- header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><?= $isEdit ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới' ?></h5>
            <a href="<?= BASE_URL ?>/admin/products" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?= $isEdit ? BASE_URL . '/admin/products/update/' . (int)$p['id'] : BASE_URL . '/admin/products/store' ?>"
                      method="POST" enctype="multipart/form-data">
                    <?= csrfField() ?>

                    <div class="row g-3">

                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-form-label">
                                    Tên sản phẩm <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="name" name="name" class="form-control"
                                       value="<?= e($p['name'] ?? '') ?>" required>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id" class="col-form-label">
                                    Danh mục <span class="text-danger">*</span>
                                </label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <?php foreach ($categories as $c): ?>
                                    <option value="<?= (int)$c['id'] ?>"
                                        <?= ($p['category_id'] ?? 0) == $c['id'] ? 'selected' : '' ?>>
                                        <?= e($c['name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="price" class="col-form-label">
                                    Giá gốc (₫) <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="price" name="price" class="form-control"
                                       value="<?= e($p['price'] ?? '') ?>" min="0" step="1000" required>
                            </div>
                        </div>

                        <!-- Sale price -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sale_price" class="col-form-label">Giá khuyến mãi (₫)</label>
                                <input type="number" id="sale_price" name="sale_price" class="form-control"
                                       value="<?= e($p['sale_price'] ?? '') ?>" min="0" step="1000">
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stock" class="col-form-label">
                                    Số lượng kho <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="stock" name="stock" class="form-control"
                                       value="<?= (int)($p['stock'] ?? 0) ?>" min="0" required>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status" class="col-form-label">Trạng thái</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="active"   <?= ($p['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Hiển thị</option>
                                    <option value="inactive" <?= ($p['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Ẩn</option>
                                </select>
                            </div>
                        </div>

                        <!-- Flash sale ends -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="flash_ends_at" class="col-form-label">Flash Sale kết thúc</label>
                                <input type="datetime-local" id="flash_ends_at" name="flash_ends_at" class="form-control"
                                       value="<?= $p['flash_ends_at'] ? date('Y-m-d\TH:i', strtotime($p['flash_ends_at'])) : '' ?>">
                            </div>
                        </div>

                        <!-- Checkboxes -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label d-block">Tuỳ chọn</label>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="is_featured"
                                           name="is_featured" <?= ($p['is_featured'] ?? 0) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="is_featured">Nổi bật</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="is_flash_sale"
                                           name="is_flash_sale" <?= ($p['is_flash_sale'] ?? 0) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="is_flash_sale">Flash Sale</label>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description" class="col-form-label">Mô tả sản phẩm</label>
                                <textarea id="description" name="description" class="form-control"
                                          rows="5"><?= e($p['description'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Cover image -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Ảnh bìa</label>
                                <?php if (!empty($p['cover_image'])): ?>
                                <div class="mb-2">
                                    <img src="<?= asset(e($p['cover_image'])) ?>" alt="cover"
                                         style="max-height:100px;border-radius:6px;">
                                </div>
                                <?php endif; ?>
                                
                                <!-- URL Input -->
                                <div class="mb-2">
                                    <input type="url" name="cover_image_url" class="form-control" 
                                           placeholder="Dán URL ảnh (https://...)" accept="image/*">
                                    <small class="text-muted">Dán link ảnh trực tiếp từ Internet, ưu tiên hơn tải file</small>
                                </div>
                                
                                <!-- File Upload -->
                                <input type="file" name="cover_image" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <!-- Extra images -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Ảnh bổ sung</label>
                                <?php if (!empty($p['images'])): ?>
                                <div class="mb-2 d-flex flex-wrap gap-2">
                                    <?php foreach ($p['images'] as $img): ?>
                                    <img src="<?= asset(e($img['image_path'])) ?>" alt="img"
                                         style="max-height:70px;border-radius:4px;">
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                
                                <!-- URL Input -->
                                <div class="mb-2">
                                    <textarea name="extra_image_urls" class="form-control" rows="3"
                                              placeholder="Dán URL ảnh (mỗi dòng 1 URL)&#10;https://example.com/image1.jpg&#10;https://example.com/image2.jpg"></textarea>
                                    <small class="text-muted">Mỗi dòng 1 URL ảnh, ưu tiên hơn tải file</small>
                                </div>
                                
                                <!-- File Upload -->
                                <input type="file" name="extra_images[]" class="form-control"
                                       accept="image/*" multiple>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fa-solid fa-floppy-disk me-1"></i>
                                <?= $isEdit ? 'Lưu thay đổi' : 'Thêm sản phẩm' ?>
                            </button>
                            <a href="<?= BASE_URL ?>/admin/products" class="btn btn-outline-secondary">Hủy</a>
                        </div>

                    </div><!-- /.row -->
                </form>
            </div>
        </div>
    </div>
</div>
