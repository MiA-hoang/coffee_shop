<?php
require_once __DIR__ . '/interface.php';
class reOrder implements RepositoryInterface {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    public function create($object) { throw new BadMethodCallException('TODO'); }
    public function getById($id) { throw new BadMethodCallException('TODO'); }
    public function update($object) { throw new BadMethodCallException('TODO'); }
    public function delete($id) { throw new BadMethodCallException('TODO'); }
}
