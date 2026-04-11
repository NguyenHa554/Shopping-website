<?php // Admin Dashboard view — Expects: $stats, $recentOrders ?>
<?php
$topOrders = array_slice($recentOrders, 0, 3);
$pendingCount = count(array_filter($recentOrders, fn($o) => ($o['status'] ?? '') === 'pending'));
$cancelledCount = count(array_filter($recentOrders, fn($o) => ($o['status'] ?? '') === 'cancelled'));
$completedCount = count(array_filter($recentOrders, fn($o) => in_array($o['status'] ?? '', ['processing', 'shipped', 'delivered'], true)));
$totalRecent = max(1, count($recentOrders));
$completedPct = min(100, max(15, (int) round(($completedCount / $totalRecent) * 100)));
$pendingPct = min(100, max(10, (int) round(($pendingCount / $totalRecent) * 100)));
$cancelledPct = min(100, max(5, (int) round(($cancelledCount / $totalRecent) * 100)));
?>
<div class="admin-dashboard">
    <div class="dashboard-hero card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
                <div>
                    <div class="text-uppercase text-primary fw-semibold small tracking-wider mb-2">Dashboard</div>
                    <h1 class="display-6 fw-bold mb-2">Chào mừng, <?= e($_SESSION['user']['full_name'] ?? 'Admin') ?></h1>
                    <p class="text-muted mb-0">Tổng quan nhanh theo phong cách SRTDash cho hệ thống SONNE.</p>
                </div>
                <div class="dashboard-hero-chip">
                    <div class="dashboard-hero-chip-label">Revenue</div>
                    <div class="dashboard-hero-chip-value"><?= formatPrice((float)$stats['revenue']) ?></div>
                    <div class="dashboard-hero-chip-sub">Doanh thu tích lũy</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="metric-card metric-blue">
                <div class="metric-head">
                    <div class="metric-icon"><i class="fa fa-box"></i></div>
                    <div class="metric-badge">24 H</div>
                </div>
                <div class="metric-title">Sản phẩm</div>
                <div class="metric-value"><?= number_format((int)$stats['products']) ?></div>
                <div class="metric-sub text-muted">Tổng sản phẩm đang quản lý</div>
                <svg viewBox="0 0 300 80" class="metric-sparkline" preserveAspectRatio="none" aria-hidden="true">
                    <path d="M0,62 C18,55 26,47 38,28 C48,14 60,12 70,32 C84,58 100,68 114,48 C128,30 140,10 154,28 C169,48 180,66 195,54 C214,39 227,18 242,28 C260,44 270,58 300,44" />
                </svg>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card metric-orange">
                <div class="metric-head">
                    <div class="metric-icon"><i class="fa fa-shopping-cart"></i></div>
                    <div class="metric-badge">24 H</div>
                </div>
                <div class="metric-title">Đơn hàng</div>
                <div class="metric-value"><?= number_format((int)$stats['orders']) ?></div>
                <div class="metric-sub text-muted">Tổng đơn đặt hàng</div>
                <svg viewBox="0 0 300 80" class="metric-sparkline metric-sparkline-orange" preserveAspectRatio="none" aria-hidden="true">
                    <path d="M0,66 C16,56 28,48 40,26 C52,8 68,12 76,34 C88,68 98,70 112,44 C125,19 138,20 150,34 C164,49 176,60 190,46 C205,28 221,18 236,36 C251,54 268,66 300,40" />
                </svg>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card metric-green">
                <div class="metric-head">
                    <div class="metric-icon"><i class="fa fa-users"></i></div>
                    <div class="metric-badge">24 H</div>
                </div>
                <div class="metric-title">Thành viên</div>
                <div class="metric-value"><?= number_format((int)$stats['users']) ?></div>
                <div class="metric-sub text-muted">Người dùng đang hoạt động</div>
                <svg viewBox="0 0 300 80" class="metric-sparkline metric-sparkline-green" preserveAspectRatio="none" aria-hidden="true">
                    <path d="M0,70 C14,58 24,52 36,44 C48,36 58,18 72,24 C86,30 94,58 110,50 C126,42 136,12 150,22 C165,33 176,58 192,56 C206,54 218,30 232,28 C246,26 258,42 272,46 C284,48 292,42 300,38" />
                </svg>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="chart-card card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h3 class="h5 fw-bold mb-1">Overview</h3>
                            <p class="text-muted small mb-0">Biểu đồ tổng quan giả lập theo layout dashboard mẫu</p>
                        </div>
                        <button type="button" class="btn btn-light btn-sm border">Last 24 Hours</button>
                    </div>
                    <div class="legend-row mb-3">
                        <span><i class="legend-dot legend-revenue"></i>Revenue</span>
                        <span><i class="legend-dot legend-expense"></i>Expenses</span>
                    </div>
                    <div class="overview-chart-wrap">
                        <svg viewBox="0 0 900 320" class="overview-chart" preserveAspectRatio="none" aria-hidden="true">
                            <defs>
                                <linearGradient id="revFill" x1="0" x2="0" y1="0" y2="1">
                                    <stop offset="0%" stop-color="#4f8cff" stop-opacity="0.32" />
                                    <stop offset="100%" stop-color="#4f8cff" stop-opacity="0.02" />
                                </linearGradient>
                                <linearGradient id="expFill" x1="0" x2="0" y1="0" y2="1">
                                    <stop offset="0%" stop-color="#ffb020" stop-opacity="0.24" />
                                    <stop offset="100%" stop-color="#ffb020" stop-opacity="0.02" />
                                </linearGradient>
                            </defs>
                            <path d="M0,205 C60,190 90,165 120,120 C160,60 205,40 250,92 C290,140 320,205 360,180 C400,155 430,105 470,75 C520,30 560,20 610,72 C660,125 700,185 740,210 C780,232 820,180 860,92 C885,38 895,30 900,34 L900,320 L0,320 Z" fill="url(#revFill)" />
                            <path d="M0,225 C60,210 95,200 125,160 C175,92 230,92 265,120 C310,156 345,178 382,142 C420,105 455,92 505,115 C556,138 585,158 625,150 C670,140 705,160 745,190 C790,225 835,215 875,140 C890,112 898,100 900,102" fill="none" stroke="#4f8cff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M0,235 C60,215 95,190 135,162 C175,135 230,110 275,120 C330,133 365,170 405,185 C450,202 485,140 520,108 C565,68 600,98 642,130 C686,164 722,176 760,182 C805,188 845,150 900,120" fill="none" stroke="#ffb020" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="chart-card card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold mb-3">Coin Distribution</h3>
                    <div class="donut-wrap">
                        <div class="donut" style="background: conic-gradient(#4f8cff 0 <?= $completedPct ?>%, #ffb020 <?= $completedPct ?>% <?= $completedPct + $pendingPct ?>%, #6f7cff <?= $completedPct + $pendingPct ?>% 100%);"></div>
                        <div class="donut-center">
                            <div class="donut-total"><?= number_format((int)$stats['orders']) ?></div>
                            <div class="donut-label">Orders</div>
                        </div>
                    </div>
                    <div class="distribution-list mt-4">
                        <div><span class="dot dot-blue"></span> Hoàn tất <strong><?= $completedPct ?>%</strong></div>
                        <div><span class="dot dot-orange"></span> Chờ xử lý <strong><?= $pendingPct ?>%</strong></div>
                        <div><span class="dot dot-purple"></span> Hủy / lỗi <strong><?= $cancelledPct ?>%</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h3 class="h5 fw-bold mb-1">Đơn hàng gần đây</h3>
                            <p class="text-muted small mb-0">Danh sách 10 đơn mới nhất</p>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/orders" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 admin-modern-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($recentOrders as $o): ?>
                                <tr>
                                    <td><a href="<?= BASE_URL ?>/admin/orders/<?= (int)$o['id'] ?>" class="text-decoration-none fw-semibold">#<?= str_pad((int)$o['id'], 6, '0', STR_PAD_LEFT) ?></a></td>
                                    <td>
                                        <div class="fw-semibold"><?= e($o['full_name']) ?></div>
                                        <div class="text-muted small"><?= e($o['email']) ?></div>
                                    </td>
                                    <td class="fw-semibold text-end"><?= formatPrice((float)$o['total']) ?></td>
                                    <td>
                                        <?= match($o['payment_method']) {
                                            'cod' => 'COD',
                                            'bank_transfer' => 'Chuyển khoản',
                                            'credit_card' => 'Thẻ',
                                            default => e($o['payment_method'])
                                        } ?>
                                    </td>
                                    <td><span class="status-pill status-<?= e($o['status']) ?>"><?= e($o['status']) ?></span></td>
                                    <td><small><?= formatDate($o['created_at'], 'd/m/Y') ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold mb-3">Quick Stats</h3>
                    <div class="quick-list">
                        <div class="quick-item">
                            <span class="quick-label">Doanh thu</span>
                            <span class="quick-value text-success"><?= formatPrice((float)$stats['revenue']) ?></span>
                        </div>
                        <div class="quick-item">
                            <span class="quick-label">Bài viết</span>
                            <span class="quick-value"><?= number_format((int)$stats['news']) ?></span>
                        </div>
                        <div class="quick-item">
                            <span class="quick-label">Liên hệ mới</span>
                            <span class="quick-value text-danger"><?= number_format((int)$stats['contacts']) ?></span>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h3 class="h6 fw-bold mb-3">Top recent</h3>
                    <div class="top-recent-list">
                        <?php foreach ($topOrders as $order): ?>
                            <div class="top-recent-item">
                                <div>
                                    <div class="fw-semibold"><?= e($order['full_name']) ?></div>
                                    <div class="text-muted small">#<?= str_pad((int)$order['id'], 6, '0', STR_PAD_LEFT) ?></div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold"><?= formatPrice((float)$order['total']) ?></div>
                                    <div class="small text-muted"><?= e($order['status']) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
