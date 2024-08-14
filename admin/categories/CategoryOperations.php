<?php

// Include config file
require_once('/var/www/html/tile2/config/DBconection.php');
class CategoryOperations {
    private $dbh;

    public function __construct() {
        $db = new DBconection();
        $this->dbh = $db->dbh;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM categories";
        $result = mysqli_query($this->dbh, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCategoryById($id) {
        $query = "SELECT * FROM categories WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function addCategory($name) {
        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "s", $name);
        return mysqli_stmt_execute($stmt);
    }

    public function updateCategory($id, $name) {
        $query = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "si", $name,$id);
        return mysqli_stmt_execute($stmt);
    }

    public function deleteCategory($id) {
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }
}
