<?php
// TODO: checkout (validate name and phone, insert tblDonHang + tblChiTietDonHang in one transaction)
// and an order history page. Use reOrder.php and models/Order.php, OrderItem.php.
class OrderController {
    public function index() {
        $pageTitle = 'Orders';
        require __DIR__ . '/../views/orders/index.php';
    }
    public function checkout() {
        $pageTitle = 'Checkout';
        require __DIR__ . '/../views/orders/checkout.php';
    }
}
