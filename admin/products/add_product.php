<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "ProductOperations.php";
require_once "/var/www/html/tile2/admin/categories/CategoryOperations.php";
$categoryOps = new CategoryOperations();
$categories = $categoryOps->getAllCategories(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Sanitize and validate inputs
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);
    $image = $_FILES['image']['name'];
    $category_ids = isset($_POST['category_ids']) ? $_POST['category_ids'] : [];

    // Check if the fields are not empty
    if (empty($name)) {
        $errors[] = "Product name is required.";
    }

    if (empty($category_ids)) {
        $errors[] = "At least one category is required.";
    }

    if (empty($price)) {
        $errors[] = "Price is required.";
    }

    if (empty($quantity)) {
        $errors[] = "Quantity is required.";
    }

    if (empty($image)) {
        $errors[] = "Product image is required.";
    }

    // Check if name is not an integer
    if (is_numeric($name)) {
        $errors[] = "Product name cannot be a number.";
    }

    // Check if price is a valid number and not a string
    if (!is_numeric($price) || floatval($price) <= 0) {
        $errors[] = "Price must be a positive number.";
    }

    // Check if quantity is a valid number and not a string
    if (!is_numeric($quantity) || intval($quantity) <= 0) {
        $errors[] = "Quantity must be a positive integer.";
    }

    // If there are errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div style='color: red;'>$error</div>";
        }
    } else {
        $productOps = new ProductOperations();
        $productOps->addProduct($name, $price, $quantity, $image, $category_ids);
        echo "<div style='color: green;'>Product added successfully!</div>";
        header("Location: products.php");
        exit();
    }
}

include 'add_product.html';
?>
