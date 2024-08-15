<?php

require_once "admin/products/ProductOperations.php";


$productOps = new ProductOperations();


$category_id = 3; 
$category_name = "Floor"; // Category name
$products = $productOps->getProductsByCategory($category_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category_name; ?> Category</title>

</head>
<body>

    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navbar.php'; ?>

    <div class="container my-5">
        <h2 class="text-center"><?php echo $category_name; ?> Products</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 text-center">
                    <h4><?php echo $product['name']; ?></h4>
                    <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid" style="width:300px; height:200px;">
                    <p>Price: Rs.<?php echo $product['price']; ?></p>
                    <button class="btn btn-primary btn-sm mt-2 add-to-cart" data-id="<?php echo $product['id']; ?>">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>