<?php // Admin pages CMS — Expects: $pages ?>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Quản lý nội dung trang</h4>
                <form action="<?= BASE_URL ?>/admin/pages/update" method="POST" enctype="multipart/form-data">
                    <?= csrfField() ?>

                    <?php
                    $keys = [
                        'about_intro' => 'Giới thiệu - Mục mở đầu',
                        'about_mission' => 'Giới thiệu - Sứ mệnh',
                        'contact_phone' => 'Liên hệ - Số điện thoại',
                        'contact_email' => 'Liên hệ - Email',
                        'contact_address' => 'Liên hệ - Địa chỉ',
                        'services_hero' => 'Dịch vụ - Tiêu đề chính',
                        'pricing_hero' => 'Bảng giá - Tiêu đề chính',
                        'seller_hero' => 'Seller - Tiêu đề chính'
                    ];
                    ?>

                    <div class="accordion" id="pagesAcc">
                        <?php $i = 0; foreach ($keys as $key => $label):
                            $row = $pages[$key] ?? [];
                            $i++;
                        ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="h<?= $i ?>">
                                <button class="accordion-button <?= $i > 1 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#c<?= $i ?>">
                                    <?= e($label) ?> <small class="ms-2 text-muted">(<?= e($key) ?>)</small>
                                </button>
                            </h2>
                            <div id="c<?= $i ?>" class="accordion-collapse collapse <?= $i === 1 ? 'show' : '' ?>" data-bs-parent="#pagesAcc">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="pages[<?= e($key) ?>][title]" value="<?= e($row['title'] ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Content</label>
                                        <textarea rows="4" class="form-control" name="pages[<?= e($key) ?>][content]"><?= e($row['content'] ?? '') ?></textarea>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control" name="page_images[<?= e($key) ?>]" accept="image/*">
                                    </div>
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="<?= asset(e($row['image'])) ?>" alt="" class="img-thumbnail mt-2" style="max-height:100px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Lưu nội dung</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
