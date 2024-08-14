<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "ProductOperations.php";
require_once "/var/www/html/tile2/admin/categories/CategoryOperations.php";


$productOps = new ProductOperations();
$product = $productOps->getProductById($_GET['id']);
$categoryOps = new CategoryOperations();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $categories = $_POST['categories']; // This should be an array of category IDs
    $price = $_POST['price'];
    $quantity= $_POST['quantity'];
    $image = $_FILES['image']['name'];

    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image);
    } else {
        $image = $product['image'];  // If no new image is uploaded, keep the old one
    }

    // Update product details
    $productOps->updateProduct($_GET['id'], $name, $price, $quantity, $image);

    // Update product categories
    $productOps->updateProductCategories($_GET['id'], $categories);

    header("Location: products.php");
    exit();
}

include 'edit_product.html';
?>
