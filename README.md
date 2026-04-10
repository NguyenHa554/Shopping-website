# SONNE - E-Commerce Website

A full-featured PHP e-commerce website . Built with a custom MVC architecture from scratch.

## Table of Contents

- [Overview](#overview)
- [Technology Stack](#technology-stack)
- [Features](#features)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Configuration](#configuration)
- [Default Accounts](#default-accounts)
- [Database Schema](#database-schema)
- [Tech Requirements](#tech-requirements)
- [License](#license)

## Overview

SONNE is an e-commerce platform specialized in beauty and skincare products. The application includes a complete shopping experience with user authentication, shopping cart, checkout process, and an admin panel for managing the store.

## Technology Stack

- **Backend**: Pure PHP (no framework)
- **Architecture**: Custom MVC (Model-View-Controller)
- **Database**: MySQL with PDO
- **Frontend**: HTML, CSS, JavaScript
- **Server**: Apache with mod_rewrite
- **Authentication**: PHP Sessions with bcrypt password hashing

## Features

### Customer Features
- Product catalog with categories
- Product search with filtering and sorting
- Product details with images, description, and reviews
- Star ratings and customer reviews
- Shopping cart (AJAX-enabled)
- Guest cart with session storage
- User registration and login
- User profile management
- Order history
- Checkout process
- Contact form
- FAQ page
- News/Blog section with comments

### Admin Features
- Admin dashboard
- User management (lock, unlock, reset password, delete)
- Product management (CRUD with image upload)
- Category management
- Order management (status updates)
- News/Article management
- FAQ management
- Contact message management
- Review management
- CMS for page content (hero section, about, contact info)

### Special Features
- Flash sales with countdown timer
- Featured products
- SEO-friendly URLs
- CSRF protection
- Image upload handling
- Pagination

## Project Structure

```
sonne/
├── index.php              # Front controller (main entry point)
├── .htaccess              # Apache URL rewriting rules
├── sonne.sql              # Database schema and seed data
├── README.md              # This file
├── .gitignore             # Git ignore file
│
├── config/                # Configuration files
│   ├── config.php         # App configuration (BASE_URL, paths, etc.)
│   └── db.php             # Database connection (PDO singleton)
│
├── core/                  # Core framework classes
│   ├── Router.php         # Custom router with named parameters
│   ├── Controller.php     # Base controller class
│   ├── Model.php          # Base model class
│   ├── Middleware.php     # Middleware support
│   └── helpers.php        # Global helper functions
│
├── controllers/           # Application controllers
│   ├── HomeController.php
│   ├── ProductController.php
│   ├── CartController.php
│   ├── OrderController.php
│   ├── AuthController.php
│   ├── UserController.php
│   ├── NewsController.php
│   ├── ContactController.php
│   ├── FaqController.php
│   ├── ReviewController.php
│   └── admin/             # Admin controllers
│       ├── AdminDashboardController.php
│       ├── AdminAuthController.php
│       ├── AdminUserController.php
│       ├── AdminProductController.php
│       ├── AdminCategoryController.php
│       ├── AdminOrderController.php
│       ├── AdminNewsController.php
│       ├── AdminContactController.php
│       ├── AdminReviewController.php
│       ├── AdminFaqController.php
│       └── AdminPageController.php
│
├── models/                # Data models
│   ├── UserModel.php
│   ├── ProductModel.php
│   ├── CategoryModel.php
│   ├── OrderModel.php
│   ├── CartModel.php
│   ├── NewsModel.php
│   ├── ReviewModel.php
│   ├── ContactModel.php
│   ├── FaqModel.php
│   └── PageContentModel.php
│
├── views/                 # View templates
│   ├── layouts/          # Layout templates
│   ├── home/             # Home page views
│   ├── product/          # Product views
│   ├── cart/             # Cart views
│   ├── checkout/         # Checkout views
│   ├── order/            # Order views
│   ├── user/             # User profile views
│   ├── news/             # News/Blog views
│   ├── contact/          # Contact views
│   ├── faq/              # FAQ views
│   ├── about/            # About page views
│   ├── errors/           # Error views (404)
│   └── admin/            # Admin views
│       └── layouts/
│
├── frontend/              # Static frontend templates (reference)
│   ├── index.html
│   ├── product.html
│   ├── cart.html
│   ├── checkout.html
│   ├── profile.html
│   ├── search.html
│   ├── seller.html
│   ├── style.css
│   └── app.js
│
└── assets/               # Static assets
    └── admin/            # Admin assets (CSS, JS)
```

## Installation

### Prerequisites

- Web server (Apache with mod_rewrite)
- PHP 7.4 or higher
- MySQL 5.7+ or MariaDB 10.3+

### Steps

1. **Clone or extract the project** to your web server directory:
   ```
   /path/to/your/web/sonne
   ```

2. **Set up the database**:
   - Create a MySQL database named `sonne_db`
   - Import the database schema and seed data:
     ```bash
     mysql -u root -p sonne_db < sonne.sql
     ```
   - Or import via phpMyAdmin or any MySQL client

3. **Configure database connection**:
   Edit `config/db.php` with your database credentials:
   ```php
   private static string $host     = '127.0.0.1';
   private static string $dbname   = 'sonne_db';
   private static string $user     = 'root';        // Your MySQL username
   private static string $password = '';           // Your MySQL password
   ```

4. **Configure base URL** (if needed):
   `config/config.php` now auto-detects base URL for both root and subfolder deployments.

5. **Configure Apache**:
   - Ensure `mod_rewrite` is enabled
   - Set the document root to the `sonne` directory
   - Or access via: `http://localhost/2212288/Web/sonne`

6. **Create uploads directory**:
   ```bash
   mkdir -p uploads/products
   chmod 755 uploads
   chmod 755 uploads/products
   ```

## Configuration

### Main Configuration (config/config.php)

| Constant | Description | Default |
|----------|-------------|---------|
| `BASE_URL` | Base URL of the application | Auto-detected |
| `ROOT_PATH` | Absolute path to project root | Auto-detected |
| `UPLOAD_PATH` | Path for uploaded files | `ROOT_PATH/uploads` |
| `MAX_UPLOAD_SIZE` | Maximum upload size | 5 MB |
| `ITEMS_PER_PAGE` | Products per page (frontend) | 12 |
| `ADMIN_ITEMS_PER_PAGE` | Items per page (admin) | 15 |
| `FLASH_SALE_DURATION` | Flash sale duration | 3 days |
| `SESSION_NAME` | Session name | `sonne_sess` |
| `APP_NAME` | Application name | `SONNE` |

### Database Configuration (config/db.php)

Update these values to match your MySQL setup:
```php
private static string $host     = '127.0.0.1';
private static string $dbname   = 'sonne_db';
private static string $user     = 'root';
private static string $password = '';
private static string $charset  = 'utf8mb4';
```


## Database Schema

The database includes 13 tables:

1. **users** - User accounts (members and admins)
2. **categories** - Product categories
3. **products** - Product catalog
4. **product_images** - Additional product images
5. **reviews** - Product reviews and ratings
6. **cart_items** - Shopping cart items
7. **orders** - Customer orders
8. **order_items** - Order line items
9. **news** - News/Blog articles
10. **news_comments** - Article comments
11. **contacts** - Contact form submissions
12. **faqs** - Frequently asked questions
13. **page_contents** - CMS content for editable pages

## Default Accounts

After importing `sonne.sql`, use these demo accounts:

- **Admin**
   - Email: `admin@sonne.vn`
   - Password: `Admin@123`

- **Member**
   - Email: `member@sonne.vn`
   - Password: `Admin@123`

## Quick Start on Windows (XAMPP)

1. Start Apache + MySQL in XAMPP.
2. Create DB and import:
    ```bash
    C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS sonne_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    C:\xampp\mysql\bin\mysql.exe -u root sonne_db < sonne.sql
    ```
3. Run with built-in PHP server (optional):
    ```bash
    C:\xampp\php\php.exe -S 127.0.0.1:8080 -t . index.php
    ```
4. Open: `http://127.0.0.1:8080`

## Tech Requirements

- **PHP**: 7.4 or higher
- **MySQL**: 5.7+ or MariaDB 10.3+
- **Apache**: 2.4+ with mod_rewrite enabled
- **PHP Extensions**: PDO, mbstring, json

## Routes

### Public Routes
- `/` - Home page
- `/about` - About page
- `/services` - Services page
- `/pricing` - Pricing page
- `/seller` - Seller registration page
- `/contact` - Contact form
- `/faq` - FAQ page
- `/login`, `/register`, `/logout` - Authentication
- `/products` - Product catalog
- `/product/{slug}` - Product detail
- `/search` - Product search
- `/category/{slug}` - Category products
- `/cart` - Shopping cart
- `/checkout` - Checkout
- `/orders` - Order history
- `/profile` - User profile
- `/news` - News list
- `/news/{slug}` - News detail

### Admin Routes
- `/admin` - Admin dashboard
- `/admin/login` - Admin login
- `/admin/users` - User management
- `/admin/products` - Product management
- `/admin/orders` - Order management
- `/admin/news` - News management
- `/admin/news-comments` - News comment moderation
- `/admin/contacts` - Contact messages
- `/admin/reviews` - Review management
- `/admin/faq` - FAQ management
- `/admin/categories` - Category management
- `/admin/pages` - CMS page content

## License

This project is for educational and demonstration purposes.

## Notes When Running On Another Machine

- Ensure the project runs from the repository root (where `index.php` is located).
- Import `sonne.sql` into a database named `sonne_db` before first run.
- Update MySQL credentials in `config/db.php` to match the target machine.
- If using Apache, enable `mod_rewrite` and allow `.htaccess` overrides.
- If using PHP built-in server, run from project root:
   - `php -S 127.0.0.1:8080 -t . index.php`
- Admin UI loads Bootstrap/Font Awesome/Google Fonts from CDN, so internet access is required for full styling.
- If ports or host differ, open the exact URL shown by your server output.

Built with care for SONNE.
