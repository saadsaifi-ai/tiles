<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "CategoryOperations.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Sanitize and validate inputs
    $name = trim($_POST['name']);

    // Check if the fields are not empty
    if (empty($name)) {
        $errors[] = "Category name is required.";
    }

    // Check if name is not an integer
    if (is_numeric($name)) {
        $errors[] = "Cateogry name cannot be a number.";
    }

    // If there are errors, display them
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

