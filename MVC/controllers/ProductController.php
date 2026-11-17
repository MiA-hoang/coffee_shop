<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repositories/reProduct.php';
require_once __DIR__ . '/../repositories/reCategory.php';
class ProductController {
    private $repository;
    private $categoryRepository;
    public function __construct() {
        $db = (new Database())->connect();
        $this->repository = new reProduct($db);
        $this->categoryRepository = new reCategory($db);
    }
    public function index() {
        $categories = $this->categoryRepository->getAll();
        $rawQ = $_GET['q'] ?? '';
        $rawCategoryId = $_GET['maDanhMuc'] ?? '';
        // Wrong parameter type (e.g. an array) -> HTTP 400
        if (!is_string($rawQ) || !is_string($rawCategoryId)) { http_response_code(400); exit('Invalid parameters.'); }
        $q = trim($rawQ);
        $rawCategoryId = trim($rawCategoryId);
        $categoryId = null;
        if ($rawCategoryId !== '') {
            // Not a positive number, or no such category -> HTTP 400
            if (!ctype_digit($rawCategoryId) || (int)$rawCategoryId <= 0 || !$this->categoryRepository->exists((int)$rawCategoryId)) {
                http_response_code(400); exit('Invalid category.');
            }
            $categoryId = (int)$rawCategoryId;
        }
        $items = $this->repository->getAll($q, $categoryId);
        $pageTitle = 'Menu';
        require __DIR__ . '/../views/products/index.php';
    }
    public function detail() {
        $rawId = $_GET['id'] ?? '';
        if (!is_string($rawId) || !ctype_digit($rawId) || (int)$rawId <= 0) { http_response_code(400); exit('Invalid product id.'); }
        $item = $this->repository->getDetail((int)$rawId);
        if (!$item) { http_response_code(404); exit('Product not found.'); }
        $pageTitle = $item['tenSanPham'];
        require __DIR__ . '/../views/products/detail.php';
    }
    public function create() {
        $categories = $this->categoryRepository->getAll();
        $values = []; $errors = [];
        $pageTitle = 'Add product';
        require __DIR__ . '/../views/products/add.php';
    }
    public function store() {
        $categories = $this->categoryRepository->getAll();
        $values = $_POST; $errors = [];
        $name = isset($values['tenSanPham']) && is_string($values['tenSanPham']) ? trim($values['tenSanPham']) : '';
        $price = isset($values['gia']) && is_string($values['gia']) ? trim($values['gia']) : '';
        $desc = isset($values['moTa']) && is_string($values['moTa']) ? trim($values['moTa']) : '';
        $categoryId = $values['maDanhMuc'] ?? '';
        if ($name === '' || mb_strlen($name, 'UTF-8') > 150) $errors[] = 'Name is required and must be at most 150 characters.';
        if (!ctype_digit($price) || (int)$price < 1 || (int)$price > 10000000) $errors[] = 'Price must be a whole number between 1 and 10,000,000.';
        if (mb_strlen($desc, 'UTF-8') > 500) $errors[] = 'Description must be at most 500 characters.';
        $validCategory = (is_string($categoryId) || is_int($categoryId)) && ctype_digit((string)$categoryId)
            && (int)$categoryId > 0 && $this->categoryRepository->exists((int)$categoryId);
        if (!$validCategory) $errors[] = 'Please choose a valid category.';
        $values['tenSanPham'] = $name;
        $values['moTa'] = $desc;
        if (!$errors) {
            $product = new Product(null, $name, (int)$price, $desc === '' ? null : $desc, null, (int)$categoryId);
            if ($this->repository->create($product)) {
                header('Location: ' . url('Product'), true, 303);
                exit;
            }
            $errors[] = 'Could not save the product. Please try again.';
        }
        $pageTitle = 'Add product';
        require __DIR__ . '/../views/products/add.php';
    }
    public function report() {
        $summary = $this->repository->summary();
        $pageTitle = 'Report';
        require __DIR__ . '/../views/products/report.php';
    }
}
