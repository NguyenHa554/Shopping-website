<?php
// Admin user edit form — Expects: $user
$u = $user;
?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Sửa thông tin thành viên</h5>
            <a href="<?= BASE_URL ?>/admin/users" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?= BASE_URL ?>/admin/users/update/<?= (int)$u['id'] ?>" method="POST">
                    <?= csrfField() ?>

                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name" class="col-form-label">
                                    Họ và tên <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="full_name" name="full_name" class="form-control"
                                       value="<?= e($u['full_name'] ?? '') ?>" required>
                            </div>
                        </div>

                        <!-- Email (Read Only) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email (Không thể phân quyền/thay đổi)</label>
                                <input type="email" id="email" class="form-control"
                                       value="<?= e($u['email'] ?? '') ?>" readonly disabled>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="col-form-label">Số điện thoại</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                       value="<?= e($u['phone'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role" class="col-form-label">
                                    Vai trò (Quản trị viên)
                                </label>
                                <select id="role" name="role" class="form-control" <?= $u['id'] == 1 ? 'disabled' : '' ?>>
                                    <option value="member" <?= ($u['role'] ?? 'member') === 'member' ? 'selected' : '' ?>>Thành viên (Member)</option>
                                    <option value="admin" <?= ($u['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Quản trị viên (Admin)</option>
                                </select>
                                <?php if ($u['id'] == 1): ?>
                                    <input type="hidden" name="role" value="admin">
                                    <small class="text-muted d-block mt-1">Tài khoản này là Super Admin, không thể hạ quyền.</small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address" class="col-form-label">Địa chỉ</label>
                                <textarea id="address" name="address" class="form-control"
                                          rows="3"><?= e($u['address'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fa-solid fa-save me-1"></i> Lưu thay đổi
                            </button>
                            <a href="<?= BASE_URL ?>/admin/users" class="btn btn-outline-secondary">Hủy</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
