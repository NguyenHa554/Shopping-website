<?php
// ============================================================
// SONNE – Front Controller
// Routes every request through the MVC stack
// ============================================================

// Absolute security: deny direct access to sensitive dirs
define('SONNE_APP', true);

// Load config and core
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Middleware.php';
require_once __DIR__ . '/core/helpers.php';

// Auto-load models and controllers
spl_autoload_register(function (string $class): void {
    $paths = [
        __DIR__ . '/models/' . $class . '.php',
        __DIR__ . '/controllers/' . $class . '.php',
        __DIR__ . '/controllers/admin/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Start session
session_name(SESSION_NAME);
session_start();

// Boot router
$router = new Router();

// ── Public routes ────────────────────────────────────────────

// Home
$router->get('/',                    'HomeController@index');
$router->get('/about',               'HomeController@about');
$router->get('/services',            'HomeController@services');
$router->get('/pricing',             'HomeController@pricing');
$router->get('/seller',              'HomeController@seller');
$router->get('/contact',             'ContactController@index');
$router->post('/contact',            'ContactController@submit');
$router->get('/faq',                 'FaqController@index');

// Auth
$router->get('/login',               'AuthController@loginForm');
$router->post('/login',              'AuthController@login');
$router->get('/register',            'AuthController@registerForm');
$router->post('/register',           'AuthController@register');
$router->get('/logout',              'AuthController@logout');

// Products
$router->get('/products',            'ProductController@index');
$router->get('/product/{slug}',      'ProductController@detail');
$router->get('/search',              'ProductController@search');
$router->get('/search/suggest',      'ProductController@suggest');
$router->get('/category/{slug}',     'ProductController@category');

// Cart (AJAX + page)
$router->get('/cart',                'CartController@index');
$router->post('/cart/add',           'CartController@add');
$router->post('/cart/update',        'CartController@update');
$router->post('/cart/remove',        'CartController@remove');
$router->post('/cart/clear',         'CartController@clear');
$router->post('/cart/sync',          'CartController@sync');   // guest merge
$router->get('/cart/count',          'CartController@count');  // AJAX badge

// Checkout & Orders
$router->get('/checkout',            'OrderController@checkoutForm');
$router->post('/checkout',           'OrderController@placeOrder');
$router->get('/order/success/{id}',  'OrderController@success');
$router->get('/orders',              'OrderController@myOrders');

// User Profile
$router->get('/profile',             'UserController@profile');
$router->post('/profile/update',     'UserController@updateProfile');
$router->post('/profile/password',   'UserController@changePassword');
$router->post('/profile/avatar',     'UserController@uploadAvatar');

// News
$router->get('/news',                'NewsController@index');
$router->get('/news/{slug}',         'NewsController@detail');
$router->post('/news/{id}/comment',  'NewsController@postComment');

// Reviews
$router->post('/review',             'ReviewController@submit');

// ── Admin routes ─────────────────────────────────────────────
$router->get('/admin',               'AdminDashboardController@index');
$router->get('/admin/dashboard',     'AdminDashboardController@index');

// Admin auth
$router->get('/admin/login',         'AdminAuthController@loginForm');
$router->post('/admin/login',        'AdminAuthController@login');
$router->get('/admin/logout',        'AdminAuthController@logout');

// Admin users
$router->get('/admin/users',         'AdminUserController@index');
$router->get('/admin/users/edit/{id}', 'AdminUserController@edit');
$router->post('/admin/users/update/{id}', 'AdminUserController@update');
$router->post('/admin/users/toggle-lock/{id}', 'AdminUserController@toggleLock');
$router->post('/admin/users/delete/{id}',  'AdminUserController@delete');
$router->post('/admin/users/reset-password/{id}', 'AdminUserController@resetPassword');

// Admin products
$router->get('/admin/products',       'AdminProductController@index');
$router->get('/admin/products/create','AdminProductController@create');
$router->post('/admin/products/store','AdminProductController@store');
$router->get('/admin/products/edit/{id}', 'AdminProductController@edit');
$router->post('/admin/products/update/{id}', 'AdminProductController@update');
$router->post('/admin/products/delete/{id}', 'AdminProductController@delete');

// Admin orders
$router->get('/admin/orders',         'AdminOrderController@index');
$router->get('/admin/orders/{id}',    'AdminOrderController@detail');
$router->post('/admin/orders/status/{id}', 'AdminOrderController@updateStatus');

// Admin carts
$router->get('/admin/carts',          'AdminCartController@index');
$router->get('/admin/carts/{id}',     'AdminCartController@detail');
$router->post('/admin/carts/status/{id}', 'AdminCartController@updateStatus');

// Admin news
$router->get('/admin/news',           'AdminNewsController@index');
$router->get('/admin/news/create',    'AdminNewsController@create');
$router->post('/admin/news/store',    'AdminNewsController@store');
$router->get('/admin/news/edit/{id}', 'AdminNewsController@edit');
$router->post('/admin/news/update/{id}', 'AdminNewsController@update');
$router->post('/admin/news/delete/{id}', 'AdminNewsController@delete');

// Admin news comments
$router->get('/admin/news-comments',           'AdminNewsCommentController@index');
$router->post('/admin/news-comments/delete/{id}', 'AdminNewsCommentController@delete');

// Admin contacts
$router->get('/admin/contacts',       'AdminContactController@index');
$router->get('/admin/contacts/{id}',  'AdminContactController@view');
$router->post('/admin/contacts/status/{id}', 'AdminContactController@updateStatus');
$router->post('/admin/contacts/delete/{id}', 'AdminContactController@delete');

// Admin reviews
$router->get('/admin/reviews',         'AdminReviewController@index');
$router->post('/admin/reviews/delete/{id}', 'AdminReviewController@delete');

// Admin FAQ
$router->get('/admin/faq',             'AdminFaqController@index');
$router->get('/admin/faq/create',      'AdminFaqController@create');
$router->post('/admin/faq/store',      'AdminFaqController@store');
$router->get('/admin/faq/edit/{id}',   'AdminFaqController@edit');
$router->post('/admin/faq/update/{id}','AdminFaqController@update');
$router->post('/admin/faq/delete/{id}','AdminFaqController@delete');

// Admin pages (CMS)
$router->get('/admin/pages',           'AdminPageController@index');
$router->post('/admin/pages/update',   'AdminPageController@update');

// Admin categories
$router->get('/admin/categories',       'AdminCategoryController@index');
$router->post('/admin/categories/store','AdminCategoryController@store');
$router->post('/admin/categories/update/{id}','AdminCategoryController@update');
$router->post('/admin/categories/delete/{id}','AdminCategoryController@delete');

// Dispatch
$router->dispatch();
