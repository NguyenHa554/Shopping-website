<?php // News list view — Expects: $articles, $pg, $keyword, $empty ?>
<section class="py-5 bg-dark text-white text-center position-relative background-cover" style="background-color: var(--primary);">
    <div class="container position-relative z-1 py-4 py-lg-5">
        <h1 class="display-4 fw-bold font-playfair mb-3">Tin tức &amp; Blog</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= url() ?>" class="text-white text-decoration-none opacity-75 hover-opacity-100">Trang chủ</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Tin tức</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5 bg-light min-vh-100">
    <div class="container py-lg-4">
        <!-- Search -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 col-lg-6">
                <form action="<?= url('news') ?>" method="GET" class="position-relative">
                    <input type="search" name="q" value="<?= e($keyword ?? '') ?>" class="form-control form-control-lg rounded-pill ps-4 pe-5 shadow-sm border-0" placeholder="Tìm kiếm bài viết...">
                    <button type="submit" class="position-absolute top-50 end-0 translate-middle-y btn bg-transparent text-primary hover-opacity-75 shadow-none border-0 pe-4">
                        <span class="material-symbols-rounded">search</span>
                    </button>
                </form>
            </div>
        </div>

        <?php if ($empty): ?>
        <div class="text-center py-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm mb-4 text-muted" style="width: 100px; height: 100px;">
                <span class="material-symbols-rounded" style="font-size: 48px;">article</span>
            </div>
            <h2 class="h4 fw-bold font-playfair mb-3">Không tìm thấy bài viết</h2>
            <p class="text-muted mb-4">Hãy thử tìm với một từ khoá khác hoặc khám phá các chủ đề khác.</p>
            <a href="<?= url('news') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">Xem tất cả tin tức</a>
        </div>
        <?php else: ?>
        <div class="row g-4 g-lg-5 mb-5">
            <?php foreach ($articles as $a): ?>
            <div class="col-md-6 col-lg-4 d-flex">
                <article class="card border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column hover-shadow transition-all w-100 bg-white">
                    <a href="<?= url('news/' . e($a['slug'])) ?>" class="position-relative overflow-hidden" style="aspect-ratio: 16/9;">
                        <?php if ($a['cover_image']): ?>
                        <img src="<?= asset(e($a['cover_image'])) ?>" alt="<?= e($a['title']) ?>" class="w-100 h-100 object-fit-cover transition-transform hover-scale" loading="lazy">
                        <?php else: ?>
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                            <span class="material-symbols-rounded" style="font-size: 48px;">newspaper</span>
                        </div>
                        <?php endif; ?>
                    </a>
                    <div class="card-body p-4 d-flex flex-column flex-grow-1">
                        <time class="text-primary small fw-medium text-uppercase tracking-wider mb-2 d-block"><?= formatDate($a['published_at']) ?></time>
                        <h2 class="h5 fw-bold font-playfair mb-3 text-truncate-2">
                            <a href="<?= url('news/' . e($a['slug'])) ?>" class="text-dark text-decoration-none hover-primary"><?= e($a['title']) ?></a>
                        </h2>
                        <p class="text-muted small mb-4 text-truncate-3 flex-grow-1"><?= truncate($a['summary'] ?? '', 120) ?></p>
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top pb-1">
                            <span class="d-flex align-items-center gap-2 small text-muted fw-medium">
                                <span class="material-symbols-rounded fs-6 border rounded-circle p-1 bg-light">person</span> 
                                <?= e($a['author_name'] ?? 'SONNE') ?>
                            </span>
                            <a href="<?= url('news/' . e($a['slug'])) ?>" class="text-primary fw-medium text-decoration-none small d-flex align-items-center gap-1 hover-opacity-75">Đọc tiếp <span class="material-symbols-rounded fs-6">arrow_forward</span></a>
                        </div>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="d-flex justify-content-center">
            <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
