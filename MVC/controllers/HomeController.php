<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repositories/reProduct.php';
class HomeController {
    public function index() {
        $featured = [];
        $dbError = false;
        try {
            $featured = (new reProduct((new Database())->connect()))->getFeatured(4);
        } catch (PDOException $e) {
            $dbError = true; // Home still renders so you can see the layout before the DB is imported.
        }
        $pageTitle = 'Home';
        require __DIR__ . '/../views/home/index.php';
    }
}
