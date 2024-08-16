<?php

// Include config file

require_once('/var/www/html/tile2/config/DBconection.php');

class ProductOperations {
    private $dbh;

    public function __construct() {
        $db = new DBconection();
        $this->dbh = $db->dbh;
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $result = mysqli_query($this->dbh, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);
        
        // Fetch associated categories
        $query = "SELECT category_id FROM product_categories WHERE product_id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $categories = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['category_id'];
        }
        
        $product['categories'] = $categories;
        return $product;
    }
    
    

    public function addProduct($name, $price, $quantity, $image, $category_ids) {

        $query = "INSERT INTO products (name, price, quantity, image) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "sdis", $name, $price, $quantity, $image);
        
        if (mysqli_stmt_execute($stmt)) {

            $product_id = mysqli_insert_id($this->dbh);
            
            // Insert categories into the product_categories table
            $query = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($this->dbh, $query);
            
            foreach ($category_ids as $category_id) {
                mysqli_stmt_bind_param($stmt, "ii", $product_id, $category_id);
                mysqli_stmt_execute($stmt);
            }
            
            return true;
        } else {
            return false;
        }
    }
    

    public function updateProduct($id, $name, $price, $quantity, $image) {
        $query = "UPDATE products SET name = ?, price = ?, quantity = ?, image = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "sdssi", $name, $price, $quantity, $image, $id);
        mysqli_stmt_execute($stmt);
    }
    

    public function updateProductCategories($productId, $categories) {
        // First, delete existing categories for the product
        $query = "DELETE FROM product_categories WHERE product_id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "i", $productId);
        mysqli_stmt_execute($stmt);
        
        // Now, insert the new categories
        foreach ($categories as $category_id) {
            $query = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($this->dbh, $query);
            mysqli_stmt_bind_param($stmt, "ii", $productId, $category_id);
            mysqli_stmt_execute($stmt);
        }
    }
    

    public function deleteProduct($id) {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }


public function getProductsByCategory($categoryId) {
    $query = "
        SELECT p.* 
        FROM products p 
        INNER JOIN product_categories pc ON p.id = pc.product_id 
        WHERE pc.category_id = ?";
    $stmt = mysqli_prepare($this->dbh, $query);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


public function getProductCategories($productId) {
    $query = "SELECT c.name FROM categories c
              JOIN product_categories pc ON c.id = pc.category_id
              WHERE pc.product_id = ?";
    $stmt = mysqli_prepare($this->dbh, $query);
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

public function getAllCategoriesWithProducts() {
    $query = "
        SELECT c.id as category_id, c.name as category_name, p.id as product_id, p.name as product_name
        FROM categories c
        LEFT JOIN product_categories pc ON c.id = pc.category_id
        LEFT JOIN products p ON pc.product_id = p.id
        ORDER BY c.name, p.name";

    $result = mysqli_query($this->dbh, $query);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        if (!isset($categories[$row['category_id']])) {
            $categories[$row['category_id']] = [
                'id' => $row['category_id'],
                'name' => $row['category_name'],
                'products' => []
            ];
        }
        if ($row['product_id']) {
            $categories[$row['category_id']]['products'][] = [
                'id' => $row['product_id'],
                'name' => $row['product_name']
            ];
        }
    }
    return array_values($categories);
}


}



