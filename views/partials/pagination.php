<?php
// Partial: pagination — expects $pg array (page, pages, total)
if (($pg['pages'] ?? 1) <= 1) return;
?>
<nav class="pagination" aria-label="Phân trang">
    <?php if ($pg['page'] > 1): ?>
    <a href="<?= pageUrl($pg['page'] - 1) ?>" class="page-btn" aria-label="Trang trước">&laquo;</a>
    <?php endif; ?>

    <?php
    $start = max(1, $pg['page'] - 2);
    $end   = min($pg['pages'], $pg['page'] + 2);
    if ($start > 1): ?><a href="<?= pageUrl(1) ?>" class="page-btn">1</a><?php
        if ($start > 2): ?><span class="page-dots">…</span><?php endif;
    endif;
    for ($i = $start; $i <= $end; $i++): ?>
    <a href="<?= pageUrl($i) ?>" class="page-btn <?= $i === $pg['page'] ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor;
    if ($end < $pg['pages']):
        if ($end < $pg['pages'] - 1): ?><span class="page-dots">…</span><?php endif;
        ?><a href="<?= pageUrl($pg['pages']) ?>" class="page-btn"><?= $pg['pages'] ?></a><?php
    endif;
    if ($pg['page'] < $pg['pages']): ?>
    <a href="<?= pageUrl($pg['page'] + 1) ?>" class="page-btn" aria-label="Trang sau">&raquo;</a>
    <?php endif; ?>
</nav>
