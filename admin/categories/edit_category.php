<?php

require "CategoryOperations.php";

$categoryOps = new CategoryOperations();
$category = $categoryOps->getCategoryById($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    $categoryOps->updateCategory($_GET['id'], $name);

    header("Location: categories.php");
    exit();
}

include 'edit_category.html';
?>

