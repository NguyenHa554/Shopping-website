<?php
defined('SONNE_APP') or die('No direct access');

class AdminProductController extends Controller {

    private function categories(): array { return CategoryModel::allWithCount(); }

    public function index(array $p): void {
        Middleware::requireAdmin();
        $search = $this->get('q');
        $total  = ProductModel::adminCount($search);
        $pg     = $this->paginate($total, ADMIN_ITEMS_PER_PAGE);
        $products = ProductModel::adminList($pg['offset'], $pg['limit'], $search);
        $this->renderAdmin('products/index', compact('products', 'pg', 'search') + ['title' => 'Quản lý sản phẩm']);
    }

    public function create(array $p): void {
        Middleware::requireAdmin();
        $this->renderAdmin('products/form', ['product' => null, 'categories' => $this->categories(), 'title' => 'Thêm sản phẩm']);
    }

    public function store(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();

        $coverPath = null;
        
        // Priority: URL > File Upload
        if (!empty($_POST['cover_image_url'])) {
            $coverPath = downloadImageFromUrl($_POST['cover_image_url'], 'products');
        } elseif (!empty($_FILES['cover_image']['name'])) {
            $coverPath = handleImageUpload($_FILES['cover_image'], 'products');
        }

        $data = [
            'category_id'  => (int)$_POST['category_id'],
            'name'         => trim($_POST['name'] ?? ''),
            'slug'         => slugify(trim($_POST['name'] ?? '')) . '-' . time(),
            'description'  => $_POST['description'] ?? null,
            'price'        => (float)($_POST['price'] ?? 0),
            'sale_price'   => $_POST['sale_price'] ? (float)$_POST['sale_price'] : null,
            'stock'        => (int)($_POST['stock'] ?? 0),
            'cover_image'  => $coverPath,
            'is_featured'  => isset($_POST['is_featured']) ? 1 : 0,
            'is_flash_sale'=> isset($_POST['is_flash_sale']) ? 1 : 0,
            'flash_ends_at'=> $_POST['flash_ends_at'] ?: null,
            'status'       => $_POST['status'] ?? 'active',
        ];
        $pid = ProductModel::create($data);

        // Extra images: Priority URLs > File Upload
        $extraImagesAdded = 0;
        if (!empty($_POST['extra_image_urls'])) {
            $urls = array_filter(array_map('trim', explode("\n", $_POST['extra_image_urls'])));
            foreach ($urls as $i => $url) {
                $path = downloadImageFromUrl($url, 'products');
                if ($path) {
                    ProductModel::addImage($pid, $path, $i);
                    $extraImagesAdded++;
                }
            }
        }
        if (!empty($_FILES['extra_images']['name'][0]) && $extraImagesAdded === 0) {
            foreach ($_FILES['extra_images']['name'] as $i => $name) {
                $file = ['name'=>$name,'type'=>$_FILES['extra_images']['type'][$i],
                         'tmp_name'=>$_FILES['extra_images']['tmp_name'][$i],
                         'error'=>$_FILES['extra_images']['error'][$i],'size'=>$_FILES['extra_images']['size'][$i]];
                $path = handleImageUpload($file, 'products');
                if ($path) ProductModel::addImage($pid, $path, $i);
            }
        }

        $this->redirectWith('/admin/products', 'success', 'Thêm sản phẩm thành công.');
    }

    public function edit(array $p): void {
        Middleware::requireAdmin();
        $product = ProductModel::find((int)($p['id'] ?? 0));
        if (!$product) { $this->redirect('/admin/products'); return; }
        $product['images'] = ProductModel::getImages((int)$product['id']);
        $this->renderAdmin('products/form', compact('product') + ['categories' => $this->categories(), 'title' => 'Sửa sản phẩm']);
    }

    public function update(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        $id      = (int)($p['id'] ?? 0);
        $product = ProductModel::find($id);
        if (!$product) { $this->redirect('/admin/products'); return; }

        $coverPath = $product['cover_image'];
        
        // Priority: URL > File Upload
        if (!empty($_POST['cover_image_url'])) {
            $newPath = downloadImageFromUrl($_POST['cover_image_url'], 'products');
            if ($newPath) {
                if ($coverPath) deleteUpload($coverPath);
                $coverPath = $newPath;
            }
        } elseif (!empty($_FILES['cover_image']['name'])) {
            if ($coverPath) deleteUpload($coverPath);
            $coverPath = handleImageUpload($_FILES['cover_image'], 'products');
        }

        ProductModel::update($id, [
            'category_id'  => (int)$_POST['category_id'],
            'name'         => trim($_POST['name'] ?? ''),
            'description'  => $_POST['description'] ?? null,
            'price'        => (float)($_POST['price'] ?? 0),
            'sale_price'   => $_POST['sale_price'] ? (float)$_POST['sale_price'] : null,
            'stock'        => (int)($_POST['stock'] ?? 0),
            'cover_image'  => $coverPath,
            'is_featured'  => isset($_POST['is_featured']) ? 1 : 0,
            'is_flash_sale'=> isset($_POST['is_flash_sale']) ? 1 : 0,
            'flash_ends_at'=> $_POST['flash_ends_at'] ?: null,
            'status'       => $_POST['status'] ?? 'active',
        ]);
        $this->redirectWith('/admin/products', 'success', 'Cập nhật sản phẩm thành công.');
    }

    public function delete(array $p): void {
        Middleware::requireAdmin();
        $this->validateCsrf();
        ProductModel::softDelete((int)($p['id'] ?? 0));
        $this->redirectWith('/admin/products', 'success', 'Đã xoá sản phẩm.');
    }
}
