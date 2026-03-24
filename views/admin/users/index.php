<?php // Admin users list — Expects: $users, $pg, $search ?>
<div class="admin-page">
    <div class="page-header"><h1>Quản lý thành viên</h1></div>
    <div class="admin-card">
        <form action="<?= BASE_URL ?>/admin/users" method="GET" class="search-bar">
            <input type="search" name="q" value="<?= e($search ?? '') ?>" placeholder="Tên hoặc email...">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </form>
        <div class="table-responsive">
            <table class="admin-table">
                <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>Role</th><th>Trạng thái</th><th>Ngày tạo</th><th>Hành động</th></tr></thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= (int)$u['id'] ?></td>
                    <td><?= e($u['full_name']) ?></td>
                    <td><?= e($u['email']) ?></td>
                    <td><span class="badge-status <?= $u['role'] === 'admin' ? 'badge-admin' : 'badge-member' ?>"><?= e($u['role']) ?></span></td>
                    <td><?= $u['is_locked'] ? '<span class="badge-status badge-inactive">Bị khóa</span>' : '<span class="badge-status badge-active">Hoạt động</span>' ?></td>
                    <td><?= formatDate($u['created_at']) ?></td>
                    <td class="actions">
                        <a href="<?= BASE_URL ?>/admin/users/edit/<?= (int)$u['id'] ?>" class="btn btn-sm btn-outline"><i class="fa fa-edit"></i></a>
                        <form action="<?= BASE_URL ?>/admin/users/toggle-lock/<?= (int)$u['id'] ?>" method="POST" style="display:inline">
                            <?= csrfField() ?>
                            <button type="submit" class="btn btn-sm <?= $u['is_locked'] ? 'btn-success' : 'btn-warning' ?>" title="<?= $u['is_locked'] ? 'Mở khóa' : 'Khóa' ?>">
                                <i class="fa <?= $u['is_locked'] ? 'fa-unlock' : 'fa-lock' ?>"></i>
                            </button>
                        </form>
                        <form action="<?= BASE_URL ?>/admin/users/reset-password/<?= (int)$u['id'] ?>" method="POST" style="display:inline"
                              onsubmit="return confirm('Đặt lại mật khẩu về Sonne@123?')">
                            <?= csrfField() ?>
                            <button type="submit" class="btn btn-sm btn-outline" title="Reset mật khẩu"><i class="fa fa-key"></i></button>
                        </form>
                        <form action="<?= BASE_URL ?>/admin/users/delete/<?= (int)$u['id'] ?>" method="POST" style="display:inline"
                              onsubmit="return confirm('Xóa thành viên này?')">
                            <?= csrfField() ?>
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
    </div>
</div>
