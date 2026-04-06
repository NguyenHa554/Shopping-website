<?php
// News detail view — Expects: $article, $comments, $recent
?>
<section class="py-5 bg-light min-vh-100">
    <div class="container py-lg-4">
        <div class="row g-5">
            <!-- Article body -->
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= url() ?>" class="text-secondary text-decoration-none hover-primary">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= url('news') ?>" class="text-secondary text-decoration-none hover-primary">Tin tức</a></li>
                        <li class="breadcrumb-item active text-dark fw-medium text-truncate" aria-current="page" style="max-width: 200px;"><?= e($article['title']) ?></li>
                    </ol>
                </nav>

                <article class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
                    <?php if ($article['cover_image']): ?>
                    <img src="<?= asset(e($article['cover_image'])) ?>" alt="<?= e($article['title']) ?>" class="w-100 object-fit-cover" style="max-height: 500px;">
                    <?php endif; ?>
                    
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-4 text-muted small fw-medium">
                            <span class="d-flex align-items-center gap-1 bg-light rounded-pill px-3 py-1">
                                <span class="material-symbols-rounded fs-6">calendar_month</span> <?= formatDate($article['published_at']) ?>
                            </span>
                            <span class="d-flex align-items-center gap-1 bg-light rounded-pill px-3 py-1">
                                <span class="material-symbols-rounded fs-6">person</span> <?= e($article['author_name'] ?? 'SONNE') ?>
                            </span>
                        </div>
                        
                        <h1 class="display-6 fw-bold font-playfair mb-5"><?= e($article['title']) ?></h1>
                        
                        <div class="article-content fs-6 lh-lg text-secondary">
                            <?= $article['body'] /* html */ ?>
                        </div>
                    </div>
                </article>

                <!-- Comments -->
                <div id="comments" class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header bg-white border-bottom p-4">
                        <h2 class="h4 fw-bold font-playfair mb-0">Bình luận (<?= count($comments) ?>)</h2>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <?php if ($comments): ?>
                        <div class="d-flex flex-column gap-4 mb-5">
                            <?php foreach ($comments as $c): ?>
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <?php if ($c['avatar']): ?>
                                    <img src="<?= asset(e($c['avatar'])) ?>" alt="<?= e($c['full_name']) ?>" class="rounded-circle object-fit-cover shadow-sm" width="48" height="48">
                                    <?php else: ?>
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-secondary shadow-sm" style="width: 48px; height: 48px;">
                                        <span class="material-symbols-rounded">person</span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1 bg-light rounded-4 p-3 p-md-4 position-relative">
                                    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-2">
                                        <strong class="text-dark d-block">
                                            <?= e($c['full_name']) ?>
                                            <?php if (!empty($c['is_admin'])): ?>
                                            <span class="badge bg-primary ms-1 fw-normal align-middle">Quản trị viên</span>
                                            <?php endif; ?>
                                        </strong>
                                        <time class="small text-muted"><?= formatDate($c['created_at'], 'd/m/Y H:i') ?></time>
                                    </div>
                                    <p class="mb-0 text-secondary lh-base"><?= nl2br(e($c['comment'])) ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-5 mb-5 bg-light rounded-4">
                            <span class="material-symbols-rounded text-muted bg-white rounded-circle p-3 shadow-sm mb-3" style="font-size: 32px;">forum</span>
                            <p class="text-muted mb-0 fw-medium">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                        </div>
                        <?php endif; ?>

                        <!-- Comment form -->
                        <?php if (isLoggedIn()): ?>
                        <div class="border-top pt-5">
                            <h3 class="h5 fw-bold font-playfair mb-4 d-flex align-items-center gap-2">
                                <span class="material-symbols-rounded text-primary">edit_square</span> Viết bình luận
                            </h3>
                            <form action="<?= url('news/' . e($article['id']) . '/comment') ?>" method="POST" class="comment-form">
                                <?= csrfField() ?>
                                <div class="form-group mb-3">
                                    <textarea name="comment" class="form-control bg-light border-0 shadow-none px-4 py-3 rounded-4" rows="4" placeholder="Nhập bình luận của bạn..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-medium shadow-sm d-flex align-items-center gap-2">
                                    <span class="material-symbols-rounded fs-5">send</span> Gửi bình luận
                                </button>
                            </form>
                        </div>
                        <?php else: ?>
                        <div class="border-top pt-4 text-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-4 py-4 px-3">
                                <p class="mb-0 fw-medium"><span class="material-symbols-rounded align-middle me-1">lock</span> Vui lòng <a href="<?= url('login') ?>" class="fw-bold text-primary hover-opacity-75">đăng nhập</a> để viết bình luận.</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="position-sticky" style="top: 2rem;">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-header bg-white border-bottom p-4">
                            <h3 class="h5 fw-bold font-playfair mb-0">Bài viết mới nhất</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush rounded-bottom-4">
                                <?php foreach ($recent as $r): if ($r['id'] == $article['id']) continue; ?>
                                <a href="<?= url('news/' . e($r['slug'])) ?>" class="list-group-item list-group-item-action text-decoration-none border-0 p-4 border-bottom hover-bg-light transition-all">
                                    <div class="d-flex gap-3 align-items-center">
                                        <?php if ($r['cover_image']): ?>
                                        <div class="flex-shrink-0">
                                            <img src="<?= asset(e($r['cover_image'])) ?>" alt="<?= e($r['title']) ?>" class="rounded-3 object-fit-cover shadow-sm" width="80" height="80">
                                        </div>
                                        <?php endif; ?>
                                        <div class="flex-grow-1">
                                            <h4 class="h6 fw-bold font-playfair mb-1 text-truncate-2 text-dark lh-base hover-primary"><?= e($r['title']) ?></h4>
                                            <time class="small text-muted fw-medium"><span class="material-symbols-rounded fs-6 align-middle me-1" style="font-size: 14px;">schedule</span><?= formatDate($r['published_at']) ?></time>
                                        </div>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
