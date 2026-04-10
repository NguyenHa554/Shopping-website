<?php // Admin categories view — Expects: $categories ?>
<div class="row">
    <!-- Left column: Add New Category Form -->
    <div class="col-lg-4 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Thêm danh mục mới</h4>
                <form action="<?= BASE_URL ?>/admin/categories/store" method="POST" enctype="multipart/form-data">
                    <?= csrfField() ?>
                    <div class="form-group mb-3">
                        <label for="name" class="col-form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Nhập tên danh mục">
                    </div>
                    <div class="form-group mb-3">
                        <label for="sort_order" class="col-form-label">Thứ tự hiển thị</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                    </div>
                    <div class="form-group mb-4">
                        <label for="image" class="col-form-label">Ảnh đại diện</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><i class="fa-solid fa-plus me-1"></i> Thêm mới</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right column: Categories Table -->
    <div class="col-lg-8 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Danh sách danh mục</h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead class="text-uppercase bg-primary">
                                <tr class="text-white">
                                    <th scope="col">ID</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col" class="text-start">Tên danh mục</th>
                                    <th scope="col">Vị trí</th>
                                    <th scope="col">Số SP</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($categories)): ?>
                                    <tr><td colspan="6">Chưa có danh mục nào.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($categories as $c): ?>
                                    <tr>
                                        <td><?= (int)$c['id'] ?></td>
                                        <td>
                                            <?php if($c['image']): ?>
                                                <img src="<?= asset(e($c['image'])) ?>" alt="" class="sonne-thumb" style="width:40px;height:40px;border-radius:4px;">
                                            <?php else: ?>
                                                <div class="bg-light text-muted d-flex align-items-center justify-content-center" style="width:40px;height:40px;border-radius:4px;margin:auto;"><i class="fa-solid fa-image"></i></div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-start fw-semibold"><?= e($c['name']) ?></td>
                                        <td><?= (int)$c['sort_order'] ?></td>
                                        <td><span class="badge bg-secondary"><?= (int)$c['product_count'] ?></span></td>
                                        <td>
                                            <!-- Edit button triggers modal -->
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit-category me-1" 
                                                    data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                                    data-id="<?= (int)$c['id'] ?>"
                                                    data-name="<?= e($c['name']) ?>"
                                                    data-sort="<?= (int)$c['sort_order'] ?>"
                                                    data-image="<?= $c['image'] ? asset(e($c['image'])) : '' ?>"
                                                    title="Sửa">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <!-- Delete button -->
                                            <form action="<?= BASE_URL ?>/admin/categories/delete/<?= (int)$c['id'] ?>" method="POST" style="display:inline" onsubmit="return confirm('Bạn có chắc chắn muốn xoá danh mục này? LƯU Ý: Không thể xoá nếu danh mục đang có sản phẩm.')">
                                                <?= csrfField() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa" <?= $c['product_count'] > 0 ? 'disabled' : '' ?>>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Sửa danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" action="<?= BASE_URL ?>/admin/categories/update/" method="POST" enctype="multipart/form-data">
                <?= csrfField() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="edit_name" class="col-form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_sort_order" class="col-form-label">Thứ tự hiển thị</label>
                        <input type="number" class="form-control" id="edit_sort_order" name="sort_order">
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-form-label">Ảnh đang dùng</label>
                        <div id="edit_image_preview" class="mb-2">
                            <span class="text-muted small">Không có ảnh</span>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="edit_image" class="col-form-label">Chọn ảnh mới (để trống nếu không đổi)</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php ob_start(); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit-category');
    const editForm = document.getElementById('editCategoryForm');
    const nameInput = document.getElementById('edit_name');
    const sortInput = document.getElementById('edit_sort_order');
    const imagePreview = document.getElementById('edit_image_preview');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const sort = this.dataset.sort;
            const image = this.dataset.image;

            // Set form action pointing to correct ID
            editForm.action = BASE_URL + '/admin/categories/update/' + id;

            // Populate inputs
            nameInput.value = name;
            sortInput.value = sort;

            // Show image preview
            if (image) {
                imagePreview.innerHTML = '<img src="' + image + '" alt="' + name + '" class="img-thumbnail" style="max-height:100px;">';
            } else {
                imagePreview.innerHTML = '<span class="text-muted small">Không có ảnh</span>';
            }
        });
    });
});
</script>
<?php $extraJs = ob_get_clean(); ?>
