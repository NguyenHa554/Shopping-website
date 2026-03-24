<?php
// News detail view — Expects: $article, $comments, $recent
?>
<article class="section news-detail-section">
    <div class="container news-detail-layout">
        <!-- Article body -->
        <div class="article-main">
            <nav class="breadcrumb">
                <a href="<?= url() ?>">Trang chủ</a><span>/</span>
                <a href="<?= url('news') ?>">Tin tức</a><span>/</span>
                <span><?= e($article['title']) ?></span>
            </nav>
            <?php if ($article['cover_image']): ?>
            <img src="<?= asset(e($article['cover_image'])) ?>" alt="<?= e($article['title']) ?>" class="article-cover">
            <?php endif; ?>
            <div class="article-meta">
                <time><i class="fa fa-calendar-alt"></i> <?= formatDate($article['published_at']) ?></time>
                <span><i class="fa fa-user"></i> <?= e($article['author_name'] ?? 'SONNE') ?></span>
            </div>
            <h1 class="article-title"><?= e($article['title']) ?></h1>
            <div class="article-body">
                <?= $article['body'] /* body is from admin WYSIWYG, already HTML */ ?>
            </div>

            <!-- Comments -->
            <div class="comments-section" id="comments">
                <h2>Bình luận (<?= count($comments) ?>)</h2>
                <?php if ($comments): ?>
                <?php foreach ($comments as $c): ?>
                <div class="comment-item">
                    <div class="comment-author">
                        <?php if ($c['avatar']): ?>
                        <img src="<?= asset(e($c['avatar'])) ?>" alt="<?= e($c['full_name']) ?>" class="comment-avatar">
                        <?php else: ?>
                        <div class="comment-avatar-placeholder"><i class="fa fa-user"></i></div>
                        <?php endif; ?>
                        <div>
                            <strong><?= e($c['full_name']) ?></strong>
                            <time><?= formatDate($c['created_at'], 'd/m/Y H:i') ?></time>
                        </div>
                    </div>
                    <p class="comment-text"><?= nl2br(e($c['comment'])) ?></p>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="no-comments">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                <?php endif; ?>

                <!-- Comment form -->
                <?php if (isLoggedIn()): ?>
                <form action="<?= url('news/' . e($article['id']) . '/comment') ?>" method="POST" class="comment-form">
                    <?= csrfField() ?>
                    <h3>Viết bình luận</h3>
                    <textarea name="comment" class="form-control" rows="4"
                              placeholder="Nhập bình luận của bạn..." required></textarea>
                    <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                </form>
                <?php else: ?>
                <div class="login-to-comment">
                    <p><a href="<?= url('login') ?>">Đăng nhập</a> để viết bình luận.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="article-sidebar">
            <h3>Bài viết mới nhất</h3>
            <?php foreach ($recent as $r): if ($r['id'] == $article['id']) continue; ?>
            <div class="recent-post">
                <?php if ($r['cover_image']): ?>
                <img src="<?= asset(e($r['cover_image'])) ?>" alt="<?= e($r['title']) ?>">
                <?php endif; ?>
                <div>
                    <a href="<?= url('news/' . e($r['slug'])) ?>" class="recent-title"><?= e($r['title']) ?></a>
                    <time><?= formatDate($r['published_at']) ?></time>
                </div>
            </div>
            <?php endforeach; ?>
        </aside>
    </div>
</article>
