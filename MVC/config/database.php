<?php
class Database {
    // Local XAMPP connection settings. Keep the database name aligned with database.sql.
    private const HOST = 'localhost';
    private const NAME = 'db_coffeeshop';
    private const USER = 'root';
    private const PASSWORD = '';

    public function connect() {
        $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::NAME . ';charset=utf8mb4';
        return new PDO($dsn, self::USER, self::PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }
}
