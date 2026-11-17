<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repositories/reCategory.php';
class CategoryController {
    private $repository;
    public function __construct() {
        $this->repository = new reCategory((new Database())->connect());
    }
    public function index() {
        $categories = $this->repository->getAllWithCount();
        $pageTitle = 'Categories';
        require __DIR__ . '/../views/categories/index.php';
    }
}
