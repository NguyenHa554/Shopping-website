<?php
// ============================================================
// SONNE – Application Configuration
// ============================================================

// Detect base URL automatically
define('BASE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')
    . '/2212288/Web/sonne');

// Absolute path to project root
define('ROOT_PATH', dirname(__DIR__));
define('UPLOAD_PATH', ROOT_PATH . '/uploads');
define('UPLOAD_URL',  BASE_URL . '/uploads');

// Max upload size (5 MB)
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024);
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);

// Pagination
define('ITEMS_PER_PAGE', 12);
define('ADMIN_ITEMS_PER_PAGE', 15);

// Flash sale duration (seconds) for countdown - 3 days default
define('FLASH_SALE_DURATION', 3 * 24 * 60 * 60);

// Session name
define('SESSION_NAME', 'sonne_sess');

// App name
define('APP_NAME', 'SONNE');
