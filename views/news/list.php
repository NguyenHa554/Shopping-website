<?php // News list view — Expects: $articles, $pg, $keyword, $empty ?>
<section class="page-hero">
    <div class="container">
        <h1>Tin tức &amp; Blog</h1>
        <nav class="breadcrumb"><a href="<?= url() ?>">Trang chủ</a><span>/</span><span>Tin tức</span></nav>
    </div>
</section>
<section class="section news-list-section">
    <div class="container">
        <!-- Search -->
        <form action="<?= url('news') ?>" method="GET" class="news-search-bar">
            <input type="search" name="q" value="<?= e($keyword ?? '') ?>" placeholder="Tìm kiếm bài viết...">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Tìm</button>
        </form>

        <?php if ($empty): ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="fa fa-newspaper"></i></div>
            <h2>Không tìm thấy bài viết</h2>
            <p>Hãy thử từ khoá khác.</p>
            <a href="<?= url('news') ?>" class="btn btn-primary">Xem tất cả tin tức</a>
        </div>
        <?php else: ?>
        <div class="news-grid">
            <?php foreach ($articles as $a): ?>
            <article class="news-card">
                <a href="<?= url('news/' . e($a['slug'])) ?>" class="news-img">
                    <?php if ($a['cover_image']): ?>
                    <img src="<?= asset(e($a['cover_image'])) ?>" alt="<?= e($a['title']) ?>" loading="lazy">
                    <?php else: ?>
                    <div class="news-img-placeholder"><i class="fa fa-newspaper"></i></div>
                    <?php endif; ?>
                </a>
                <div class="news-body">
                    <time class="news-date"><?= formatDate($a['published_at']) ?></time>
                    <h2 class="news-title"><a href="<?= url('news/' . e($a['slug'])) ?>"><?= e($a['title']) ?></a></h2>
                    <p class="news-summary"><?= truncate($a['summary'] ?? '', 120) ?></p>
                    <div class="news-meta">
                        <span><i class="fa fa-user"></i> <?= e($a['author_name'] ?? 'SONNE') ?></span>
                        <a href="<?= url('news/' . e($a['slug'])) ?>" class="read-more">Đọc tiếp →</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php include ROOT_PATH . '/views/partials/pagination.php'; ?>
        <?php endif; ?>
    </div>
</section>
