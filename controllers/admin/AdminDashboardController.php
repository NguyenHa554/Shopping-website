<?php
defined('SONNE_APP') or die('No direct access');

class AdminDashboardController extends Controller {
    public function index(array $p): void {
        Middleware::requireAdmin();
        $stats = [
            'users'    => DB::count("SELECT COUNT(*) FROM users WHERE deleted_at IS NULL AND role='member'"),
            'products' => DB::count("SELECT COUNT(*) FROM products WHERE deleted_at IS NULL"),
            'orders'   => DB::count("SELECT COUNT(*) FROM orders"),
            'revenue'  => DB::fetchOne("SELECT COALESCE(SUM(total),0) AS t FROM orders WHERE status != 'cancelled'")['t'] ?? 0,
            'news'     => DB::count("SELECT COUNT(*) FROM news WHERE deleted_at IS NULL"),
            'contacts' => DB::count("SELECT COUNT(*) FROM contacts WHERE status='unread'"),
        ];
        $recentOrders = DB::fetchAll(
            "SELECT o.*, u.full_name AS user_name FROM orders o LEFT JOIN users u ON u.id=o.user_id ORDER BY o.id DESC LIMIT 10"
        );
        $this->renderAdmin('dashboard/index', compact('stats', 'recentOrders') + ['title' => 'Dashboard – Admin SONNE']);
    }
}
