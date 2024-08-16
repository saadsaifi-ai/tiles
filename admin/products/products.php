<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Manage Products</h1>
        <div class="mb-3">
            <a href="add_product.php" class="btn btn-success">Add New Product</a>
            <a href="../dashbored.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Product ID</th>
                    <th>Categories</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require "ProductOperations.php";

                $productOps = new ProductOperations();
                $products = $productOps->getAllProducts();


                foreach ($products as $product) {
                    // Fetch categories for the current product
                    $categories = $productOps->getProductCategories($product['id']);
                    $categoryNames = array_column($categories, 'name');
                    $categoryList = implode(', ', $categoryNames);

                    echo "<tr>";
                    echo "<td>{$product['id']}</td>";
                    echo "<td>{$categoryList}</td>";
                    echo "<td>{$product['name']}</td>";
                    echo "<td>{$product['price']}</td>";
                    echo "<td>{$product['quantity']}</td>";
                    echo "<td><img src='../../images/{$product['image']}' width='50' class='img-thumbnail'></td>";
                    echo "<td>
                            <a href='edit_product.php?id={$product['id']}' class='btn btn-warning btn-sm'>Edit</a> 
                            <a href='delete_product.php?id={$product['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
