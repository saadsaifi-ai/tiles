<?php
require_once "admin/products/ProductOperations.php";

$productOps = new ProductOperations();
$categories = $productOps->getAllCategoriesWithProducts();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary shadow-sm p-3 mb-5">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
            <!-- Multilevel Dropdown for Categories -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                    <?php foreach ($categories as $category): ?>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item" href="category.php?id=<?php echo $category['id']; ?>&name=<?php echo $category['name']; ?>">
                                <?php echo $category['name']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($category['products'] as $product): ?>
                                    <li><a class="dropdown-item" href="product.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="users/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users/cart.php">
                    <i class="fas fa-shopping-cart"></i> Cart
                    <span id="cart-count" class="badge badge-pill badge-light">0</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- CSS for Multilevel Dropdown -->
<style>
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
    }
</style>

<script>
    $(document).ready(function() {
        // Show the submenu on hover
        $('.dropdown-submenu').hover(function() {
            $(this).children('.dropdown-menu').show();
        }, function() {
            $(this).children('.dropdown-menu').hide();
        });
    });
</script>
