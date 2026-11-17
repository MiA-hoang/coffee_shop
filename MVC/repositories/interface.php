<?php
interface RepositoryInterface {
    public function create($object);
    public function getById($id);
    public function update($object);
    public function delete($id);
}
