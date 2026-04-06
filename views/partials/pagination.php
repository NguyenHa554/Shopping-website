<?php
// Partial: pagination - expects $pg array (page, pages, total)
if (($pg['pages'] ?? 1) <= 1) return;
?>
<nav aria-label="Page navigation" class="mt-4 d-flex justify-content-center">
    <ul class="pagination pagination-md justify-content-center align-items-center border-0 shadow-sm rounded-pill py-2 px-3 bg-white d-inline-flex gap-1 mx-auto flex-wrap">
        <?php if ($pg['page'] > 1): ?>
        <li class="page-item">
            <a href="<?= pageUrl($pg['page'] - 1) ?>" class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 text-dark hover-bg-light" style="width: 40px; height: 40px;" aria-label="Trang truoc"><i class="ti-angle-left"></i></a>
        </li>
        <?php endif; ?>

        <?php
        $start = max(1, $pg['page'] - 2);
        $end   = min($pg['pages'], $pg['page'] + 2);
        if ($start > 1): ?>
        <li class="page-item"><a href="<?= pageUrl(1) ?>" class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 fw-medium text-dark hover-bg-light" style="width: 40px; height: 40px;">1</a></li>
        <?php if ($start > 2): ?>
        <li class="page-item disabled"><span class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 text-muted bg-transparent" style="width: 40px; height: 40px;">...</span></li>
        <?php endif;
        endif;

        for ($i = $start; $i <= $end; $i++): ?>
        <li class="page-item <?= $i === $pg['page'] ? 'active' : '' ?>">
            <a href="<?= pageUrl($i) ?>" class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 fw-medium <?= $i === $pg['page'] ? 'bg-primary text-white shadow-sm' : 'text-dark hover-bg-light' ?>" style="width: 40px; height: 40px;"><?= $i ?></a>
        </li>
        <?php endfor;

        if ($end < $pg['pages']):
            if ($end < $pg['pages'] - 1): ?>
            <li class="page-item disabled"><span class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 text-muted bg-transparent" style="width: 40px; height: 40px;">...</span></li>
            <?php endif; ?>
        <li class="page-item"><a href="<?= pageUrl($pg['pages']) ?>" class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 fw-medium text-dark hover-bg-light" style="width: 40px; height: 40px;"><?= $pg['pages'] ?></a></li>
        <?php endif;

        if ($pg['page'] < $pg['pages']): ?>
        <li class="page-item">
            <a href="<?= pageUrl($pg['page'] + 1) ?>" class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 text-dark hover-bg-light" style="width: 40px; height: 40px;" aria-label="Trang sau"><i class="ti-angle-right"></i></a>
        </li>
        <?php endif; ?>
    </ul>
    <style>
    .page-link:focus { box-shadow: none; }
    .hover-bg-light:hover { background-color: #f8f9fa !important; }
    </style>
</nav>
