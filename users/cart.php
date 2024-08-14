<?php
require_once "cart_operations.php";

$cartOps = new CartOperations();
$user_id = $_SESSION['id']??0;

$action = isset($_GET['action']) ? $_GET['action'] : null;
$product_id = isset($_GET['id']) ? intval($_GET['id']) : null;


if ($action == 'add' && $product_id) {
    $cartOps->addToCart($user_id, $product_id, 1);
    header("Location: cart.php");
    exit();
}

if ($action == 'remove' && $product_id) {
    $cartOps->removeFromCart($product_id);
    header("Location: cart.php");
    exit();
}

$cartItems = $cartOps->getCartItems($user_id);
$total = $cartOps->getCartTotal($user_id);

include 'cart.html';
?>
