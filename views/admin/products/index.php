<?php // Admin products list — Expects: $products, $pg, $search ?>
<div class="admin-page">
    <div class="page-header">
        <h1>Quản lý sản phẩm</h1>
        <a href="<?= BASE_URL ?>/admin/products/create" class="btn btn-primary">
            <i class="fa fa-plus"></i> Thêm sản phẩm
        </a>
    </div>
    <div class="admin-card">
        <form action="<?= BASE_URL ?>/admin/products" method="GET" class="search-bar">
            <input type="search" name="q" value="<?= e($search ?? '') ?>" placeholder="Tìm sản phẩm...">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </form>
        <div class="table-responsive">
            <table class="admin-table">
                <thead><tr><th>#</th><th>Ảnh</th><th>Tên</th><th>Danh mục</th><th>Giá</th><th>Kho</th><th>Trạng thái</th><th>Hành động</th></tr></thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= (int)$p['id'] ?></td>
                    <td><img src="<?= $p['cover_image'] ? asset(e($p['cover_image'])) : '' ?>" alt="" class="table-thumb"></td>
                    <td><?= e($p['name']) ?></td>
                    <td><?= e($p['category_name']) ?></td>
                    <td><?= formatPrice((float)($p['sale_price'] ?? $p['price'])) ?><?= $p['sale_price'] ? '<br><del class="text-muted">'.formatPrice((float)$p['price']).'</del>' : '' ?></td>
                    <td><?= (int)$p['stock'] ?></td>
                    <td><span class="badge-status <?= $p['status'] === 'active' ? 'badge-active' : 'badge-inactive' ?>"><?= e($p['status']) ?></span></td>
                    <td class="actions">
                        <a href="<?= BASE_URL ?>/admin/products/edit/<?= (int)$p['id'] ?>" class="btn btn-sm btn-outline"><i class="fa fa-edit"></i></a>
                        <form action="<?= BASE_URL ?>/admin/products/delete/<?= (int)$p['id'] ?>" method="POST" style="display:inline"
                              onsubmit="return confirm('Xóa sản phẩm này?')">
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
