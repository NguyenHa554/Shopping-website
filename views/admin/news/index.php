<?php // Admin news list — Expects: $articles, $pg, $search ?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Quản lý tin tức</h5>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/admin/news-comments" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-comments me-1"></i> Bình luận
                </a>
                <a href="<?= BASE_URL ?>/admin/news/create" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-1"></i> Thêm bài viết
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?= BASE_URL ?>/admin/news" method="GET" class="mb-3">
                    <div class="input-group" style="max-width:400px;">
                        <input type="search" name="q" value="<?= e($search ?? '') ?>" class="form-control" placeholder="Tìm tiêu đề bài viết...">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                    </div>
                </form>

                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-uppercase bg-primary">
                                <tr class="text-white">
                                    <th>ID</th>
                                    <th>Ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Tác giả</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đăng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($articles as $a): ?>
                                <tr>
                                    <td><?= (int)$a['id'] ?></td>
                                    <td>
                                        <?php if (!empty($a['cover_image'])): ?>
                                            <img src="<?= asset(e($a['cover_image'])) ?>" alt="" class="sonne-thumb" style="width:56px;height:56px;object-fit:cover;">
                                        <?php else: ?>
                                            <div class="bg-light text-muted d-flex align-items-center justify-content-center" style="width:56px;height:56px;border-radius:4px;">N/A</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?= e($a['title']) ?></div>
                                        <small class="text-muted"><?= e($a['slug']) ?></small>
                                    </td>
                                    <td><?= e($a['author_name'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="badge <?= ($a['status'] ?? 'draft') === 'published' ? 'bg-success' : 'bg-secondary' ?>">
                                            <?= e($a['status'] ?? 'draft') ?>
                                        </span>
                                    </td>
                                    <td><small><?= !empty($a['published_at']) ? formatDate($a['published_at'], 'd/m/Y H:i') : '-' ?></small></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/admin/news/edit/<?= (int)$a['id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Sửa">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="<?= BASE_URL ?>/admin/news/delete/<?= (int)$a['id'] ?>" method="POST" style="display:inline" onsubmit="return confirm('Xóa bài viết này?')">
                                            <?= csrfField() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($articles)): ?>
                                <tr><td colspan="7" class="text-center">Không có dữ liệu.</td></tr>
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
