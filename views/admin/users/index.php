<?php // Admin users list — Expects: $users, $pg, $search ?>
<div class="row">
    <div class="col-12 mt-4">
        <!-- page actions -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Quản lý thành viên</h5>
            <!-- Note: If there's an add user view later, link it here -->
            <a href="javascript:void(0)" class="btn btn-primary d-none">
                <i class="fa-solid fa-plus me-1"></i> Thêm thành viên
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- search bar -->
                <form action="<?= BASE_URL ?>/admin/users" method="GET" class="mb-3">
                    <div class="input-group" style="max-width:400px;">
                        <input type="search" name="q" value="<?= e($search ?? '') ?>"
                               class="form-control" placeholder="Tìm tên hoặc email...">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>
                </form>

                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead class="text-uppercase bg-primary">
                                <tr class="text-white">
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-start">Họ tên</th>
                                    <th scope="col" class="text-start">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= (int)$u['id'] ?></td>
                                <td class="text-start fw-semibold"><?= e($u['full_name']) ?></td>
                                <td class="text-start"><?= e($u['email']) ?></td>
                                <td>
                                    <span class="badge <?= $u['role'] === 'admin' ? 'bg-danger' : 'bg-info' ?>">
                                        <?= e(strtoupper($u['role'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($u['is_locked']): ?>
                                        <span class="badge bg-secondary">Bị khóa</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php endif; ?>
                                </td>
                                <td><small><?= formatDate($u['created_at']) ?></small></td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <!-- Edit User -->
                                        <a href="<?= BASE_URL ?>/admin/users/edit/<?= (int)$u['id'] ?>"
                                           class="btn btn-sm btn-outline-primary" title="Sửa">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <!-- Lock/Unlock User -->
                                        <form action="<?= BASE_URL ?>/admin/users/toggle-lock/<?= (int)$u['id'] ?>"
                                              method="POST" style="margin: 0;">
                                            <?= csrfField() ?>
                                            <button type="submit" class="btn btn-sm <?= $u['is_locked'] ? 'btn-success' : 'btn-warning' ?>"
                                                    title="<?= $u['is_locked'] ? 'Mở khóa' : 'Khóa' ?>">
                                                <i class="fa-solid <?= $u['is_locked'] ? 'fa-unlock' : 'fa-lock' ?>"></i>
                                            </button>
                                        </form>

                                        <!-- Reset Password -->
                                        <form action="<?= BASE_URL ?>/admin/users/reset-password/<?= (int)$u['id'] ?>"
                                              method="POST" style="margin: 0;"
                                              onsubmit="return confirm('Đặt lại mật khẩu về Sonne@123?')">
                                            <?= csrfField() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-dark" title="Reset mật khẩu">
                                                <i class="fa-solid fa-key"></i>
                                            </button>
                                        </form>

                                        <!-- Delete User -->
                                        <form action="<?= BASE_URL ?>/admin/users/delete/<?= (int)$u['id'] ?>"
                                              method="POST" style="margin: 0;"
                                              onsubmit="return confirm('Xóa thành viên này?')">
                                            <?= csrfField() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="7">Không tìm thấy thành viên.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
            </div>
        </div>
    </div>
</div>
