<?php // Admin products list — Expects: $products, $pg, $search ?>
<div class="row">
    <div class="col-12 mt-4">
        <!-- page actions -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Danh sách sản phẩm</h5>
            <a href="<?= BASE_URL ?>/admin/products/create" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i> Thêm sản phẩm
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- search bar -->
                <form action="<?= BASE_URL ?>/admin/products" method="GET" class="mb-3">
                    <div class="input-group" style="max-width:400px;">
                        <input type="search" name="q" value="<?= e($search ?? '') ?>"
                               class="form-control" placeholder="Tìm sản phẩm...">
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
                                    <th scope="col">Ảnh</th>
                                    <th scope="col" class="text-start">Tên sản phẩm</th>
                                    <th scope="col">Danh mục</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Kho</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?= (int)$p['id'] ?></td>
                                <td>
                                    <img src="<?= $p['cover_image'] ? asset(e($p['cover_image'])) : '' ?>"
                                         alt="" class="sonne-thumb">
                                </td>
                                <td class="text-start fw-semibold"><?= e($p['name']) ?></td>
                                <td><?= e($p['category_name']) ?></td>
                                <td>
                                    <?= formatPrice((float)($p['sale_price'] ?? $p['price'])) ?>
                                    <?= $p['sale_price'] ? '<br><del class="text-muted small">'.formatPrice((float)$p['price']).'</del>' : '' ?>
                                </td>
                                <td><?= (int)$p['stock'] ?></td>
                                <td>
                                    <span class="badge <?= $p['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $p['status'] === 'active' ? 'Hiển thị' : 'Ẩn' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>/admin/products/edit/<?= (int)$p['id'] ?>"
                                       class="btn btn-sm btn-outline-primary me-1" title="Sửa">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="<?= BASE_URL ?>/admin/products/delete/<?= (int)$p['id'] ?>"
                                          method="POST" style="display:inline"
                                          onsubmit="return confirm('Xóa sản phẩm này?')">
                                        <?= csrfField() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
            </div>
        </div>
    </div>
</div>
