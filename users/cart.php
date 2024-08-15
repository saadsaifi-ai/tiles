<?php
require_once "cart_operations.php";

$cartOps = new CartOperations();
$user_id = $_SESSION['id']??0;

$action = isset($_GET['action']) ? $_GET['action'] : null;
$product_id = isset($_GET['id']) ? intval($_GET['id']) : null;


if ($action == 'add' && $product_id) {
    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to session cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    
    $cartOps->addToCart($user_id, $product_id, 1);
    header("Location: cart.php");
    echo json_encode(['success' => true]);
    exit();
}

if ($action == 'remove' && $product_id) {
    $cartOps->removeFromCart($product_id);

    // Remove product from session cart
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    $cartOps->removeFromCart($product_id);
    header("Location: cart.php");
    echo json_encode(['success' => true]);
    exit();
}

if ($action == 'count') {
    $cartCount = 0;
    if (isset($_SESSION['cart'])) {
        $cartCount = array_sum($_SESSION['cart']);  // Total count of products
    }
    echo json_encode(['count' => $cartCount]);
    exit;
}



$cartItems = $cartOps->getCartItems($user_id);
$total = $cartOps->getCartTotal($user_id);

include 'cart.html';
?>
