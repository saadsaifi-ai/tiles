<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "CategoryOperations.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $name = trim($_POST['name']);

    if (empty($name)) {
        $errors[] = "Category name is required.";
    }

    if (is_numeric($name)) {
        $errors[] = "Cateogry name cannot be a number.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div style='color: red;'>$error</div>";
        }
    } else {
        $categoryOps = new CategoryOperations();
        $categoryOps->addCategory($name);
        echo "<script>alert('Product Added!');</script>";
        echo "<div style='color: green;'>Product added successfully!</div>";
            header("Location: categories.php");
    exit();
    }
}

include 'add_category.html';
?>

