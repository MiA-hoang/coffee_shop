<?php
// TODO: session-based cart (add, remove, change quantity), then link it from the product detail page.
class CartController {
    public function index() {
        $pageTitle = 'Cart';
        require __DIR__ . '/../views/cart/index.php';
    }
}
