<?php // Admin news comments — Expects: $comments, $pg, $search ?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Quản lý bình luận tin tức</h5>
            <a href="<?= BASE_URL ?>/admin/news" class="btn btn-outline-secondary">Quay về Tin tức</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?= BASE_URL ?>/admin/news-comments" method="GET" class="mb-3">
                    <div class="input-group" style="max-width:420px;">
                        <input type="search" name="q" value="<?= e($search ?? '') ?>" class="form-control" placeholder="Tìm bài viết, người dùng, nội dung...">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="text-uppercase bg-dark">
                            <tr class="text-white">
                                <th>ID</th>
                                <th>Bài viết</th>
                                <th>Người dùng</th>
                                <th>Nội dung</th>
                                <th>Ngày tạo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($comments as $c): ?>
                            <tr>
                                <td><?= (int)$c['id'] ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>/news/<?= e($c['news_slug']) ?>" target="_blank" class="fw-semibold text-decoration-none">
                                        <?= e($c['news_title']) ?>
                                    </a>
                                </td>
                                <td><?= e($c['user_name']) ?></td>
                                <td style="max-width:420px;"><div class="text-wrap"><?= e($c['comment']) ?></div></td>
                                <td><small><?= formatDate($c['created_at'], 'd/m/Y H:i') ?></small></td>
                                <td>
                                    <form action="<?= BASE_URL ?>/admin/news-comments/delete/<?= (int)$c['id'] ?>" method="POST" onsubmit="return confirm('Xóa bình luận này?')">
                                        <?= csrfField() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($comments)): ?>
                            <tr><td colspan="6" class="text-center">Không có bình luận.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
            </div>
        </div>
    </div>
</div>
