<?php
require_once "cart_operations.php";

$cartOps = new CartOperations();
$user_id = $_SESSION['id']??0;

$product_id = isset($_POST['id']) ? intval($_POST['id']) : null;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : null;

// Debugging output
error_log(print_r($_POST, true));

if ($product_id && $quantity !== null) {

    // Update the quantity in the cart
    $cartOps->updateCartQuantity($product_id, $quantity);

    echo json_encode(['status' => 'success']); // Respond with success
    exit();
}else{
        echo("failed");

    }

$cartItems = $cartOps->getCartItems($user_id);
$total = $cartOps->getCartTotal($user_id);

include 'cartquantity.html';
?>
