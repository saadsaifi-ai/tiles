<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="text-center">
        <h1 class="mb-4">Admin Dashboard</h1>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-md-3 mb-3">
            <a href="products/products.php" class="btn btn-warning btn-block">Manage Products</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="categories/categories.php" class="btn btn-secondary btn-block">Manage Categories</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="orders/manage_orders.php" class="btn btn-success btn-block">Manage Orders</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="orders/generate_pdf.php" class="btn btn-info">Download Orders PDF</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="logout.php" class="btn btn-danger btn-block">Logout</a>
        </div>
    </div>
</div>

</body>
</html>


