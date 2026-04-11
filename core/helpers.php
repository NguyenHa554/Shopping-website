<?php
// ============================================================
// SONNE – Global Helper Functions
// ============================================================

/**
 * Safely escape HTML output
 */
function e(mixed $value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Format price in Vietnamese locale
 */
function formatPrice(float $amount): string {
    return number_format($amount, 0, ',', '.') . ' ₫';
}

/**
 * Generate CSRF hidden input field
 */
function csrfField(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return '<input type="hidden" name="csrf_token" value="' . e($_SESSION['csrf_token']) . '">';
}

/**
 * Retrieve and clear flash message from session
 */
function flash(): ?array {
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

/**
 * Get current logged-in user
 */
function currentUser(): ?array {
    return $_SESSION['user'] ?? null;
}

/**
 * Check if logged in
 */
function isLoggedIn(): bool {
    return isset($_SESSION['user']);
}

/**
 * Check if admin
 */
function isAdmin(): bool {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

/**
 * Generate a URL-safe slug from a string
 */
function slugify(string $text): string {
    $text = mb_strtolower($text, 'UTF-8');
    // Transliterate Vietnamese chars
    $from = ['à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă','ằ','ắ','ặ','ẳ','ẵ',
              'è','é','ẹ','ẻ','ẽ','ê','ề','ế','ệ','ể','ễ',
              'ì','í','ị','ỉ','ĩ','ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ','ờ','ớ','ợ','ở','ỡ',
              'ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ','ỳ','ý','ỵ','ỷ','ỹ','đ'];
    $to   = ['a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a',
              'e','e','e','e','e','e','e','e','e','e','e',
              'i','i','i','i','i','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o',
              'u','u','u','u','u','u','u','u','u','u','u','y','y','y','y','y','d'];
    $text = str_replace($from, $to, $text);
    $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

/**
 * Handle image upload, returns relative path or null
 */
function handleImageUpload(array $file, string $subDir = 'products'): ?string {
    if ($file['error'] !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > MAX_UPLOAD_SIZE) return null;

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!in_array($mime, ALLOWED_IMAGE_TYPES, true)) return null;

    $ext  = match($mime) {
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        default      => 'jpg',
    };

    $dir = UPLOAD_PATH . '/' . $subDir;
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $filename = uniqid('', true) . '.' . $ext;
    $dest     = $dir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) return null;

    return 'uploads/' . $subDir . '/' . $filename;
}

/**
 * Download image from URL and save to uploads directory, returns relative path or null
 */
function downloadImageFromUrl(string $url, string $subDir = 'products'): ?string {
    $url = trim($url);
    if (empty($url)) return null;

    // Validate URL format
    if (!filter_var($url, FILTER_VALIDATE_URL)) return null;

    // Only allow HTTP/HTTPS
    $parsed = parse_url($url);
    if (!in_array($parsed['scheme'] ?? '', ['http', 'https'])) return null;

    // Fetch image with cURL
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; ImageDownloader/1.0)',
    ]);
    $imageData = curl_exec($ch);
    $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);

    if ($httpCode !== 200 || !$imageData) return null;

    // Validate it's an image
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->buffer($imageData);
    if (!in_array($mime, ALLOWED_IMAGE_TYPES, true)) return null;

    // Check file size
    if (strlen($imageData) > MAX_UPLOAD_SIZE) return null;

    $ext  = match($mime) {
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        default      => 'jpg',
    };

    $dir = UPLOAD_PATH . '/' . $subDir;
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $filename = uniqid('', true) . '.' . $ext;
    $dest     = $dir . '/' . $filename;

    if (file_put_contents($dest, $imageData) === false) return null;

    return 'uploads/' . $subDir . '/' . $filename;
}

/**
 * Delete an uploaded file safely (must be inside uploads/)
 */
function deleteUpload(string $relativePath): void {
    if (!$relativePath) return;
    $full = ROOT_PATH . '/' . ltrim($relativePath, '/');
    if (str_starts_with(realpath(dirname($full)) ?: '', UPLOAD_PATH) && file_exists($full)) {
        unlink($full);
    }
}

/**
 * Truncate text to N chars with ellipsis
 */
function truncate(string $text, int $len = 120): string {
    $plain = strip_tags($text);
    return mb_strlen($plain) > $len ? mb_substr($plain, 0, $len) . '…' : $plain;
}

/**
 * Format datetime string for display
 */
function formatDate(string $datetime, string $format = 'd/m/Y'): string {
    return date($format, strtotime($datetime));
}

/**
 * Pagination URL helper – appends ?page=N to current URL
 */
function pageUrl(int $page): string {
    $query = $_GET;
    $query['page'] = $page;
    return '?' . http_build_query($query);
}

/**
 * Build URL
 */
function url(string $path = ''): string {
    return BASE_URL . '/' . ltrim($path, '/');
}

/**
 * Asset URL (for CSS/JS/images inside sonne/)
 */
function asset(string $path): string {
    return BASE_URL . '/' . ltrim($path, '/');
}
