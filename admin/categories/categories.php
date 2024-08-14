<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Categories</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Manage Categories</h1>
        <div class="mb-3">
            <a href="add_category.php" class="btn btn-success me-2">Add New Category</a>
            <a href="../dashbored.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Category ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "../../config/DBconection.php";
                require "CategoryOperations.php";

                $categoryOps = new CategoryOperations();
                $categories = $categoryOps->getAllCategories();

                foreach ($categories as $category) {
                    echo "<tr>";
                    echo "<td>{$category['id']}</td>";
                    echo "<td>{$category['name']}</td>";
                    echo "<td>
                            <a href='edit_category.php?id={$category['id']}' class='btn btn-warning btn-sm me-1'>Edit</a>
                            <a href='delete_category.php?id={$category['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
