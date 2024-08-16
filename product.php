<?php
require_once "admin/products/ProductOperations.php";
require_once "admin/categories/CategoryOperations.php";

$productOps = new ProductOperations();
$categoryOps = new CategoryOperations();

$product_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($product_id) {

    $products = $productOps->getProductById($product_id);
    if ($products) {

        $categoryNames = [];
        foreach ($products['categories'] as $category_id) {
            $category = $categoryOps->getCategoryById($category_id);
            if ($category) {
                $categoryNames[] = $category['name'];
            }
        }
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "No product selected.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($products['name']); ?> - Product Details</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navbar.php'; ?>
    <div class="container my-5">
        <h2 class="text-center"><?php echo htmlspecialchars($products['name']); ?></h2>
        <div class="text-center">
            <img src="images/<?php echo htmlspecialchars($products['image']); ?>" alt="<?php echo htmlspecialchars($products['name']); ?>" class="img-fluid">
            <p>Price: Rs.<?php echo htmlspecialchars($products['price']); ?></p>
            <p>Category: <?php echo htmlspecialchars(implode(', ', $categoryNames)); ?></p> 
            <button class="btn btn-primary btn-sm mt-2 add-to-cart" data-id="<?php echo htmlspecialchars($products['id']); ?>">
                <i class="fas fa-shopping-cart"></i> Add to Cart
            </button>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
