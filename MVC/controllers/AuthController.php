<?php
// TODO: login/logout with password_hash() / password_verify(), then store the user id in $_SESSION.
class AuthController {
    public function login() {
        $pageTitle = 'Log in';
        require __DIR__ . '/../views/auth/login.php';
    }
}
