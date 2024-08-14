<?php
require_once "cart_operations.php";

$cartOps = new CartOperations();
$user_id = $_SESSION['id']; 

$cartItems = $cartOps->getCartItems($user_id);
$total = $cartOps->getCartTotal($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // Validate stock before placing the order
    $insufficientStockItems = [];

    foreach ($cartItems as $item) {
        $availableStock = $cartOps->getProductStock($item['product_id']);
        if ($item['quantity'] > $availableStock) {
            $insufficientStockItems[] = $item['name']; // Add product name to the list
        }
    }

    if (empty($insufficientStockItems)) {
        // Save user details to the user_details table
        $cartOps->saveUserDetails($user_id, $contact, $address);

        // Create order and order items
        $order_id = $cartOps->createOrder($user_id, $total);
        $cartOps->createOrderItems($order_id, $cartItems);

        // Clear the cart
        $cartOps->clearCart($user_id);

        // Redirect to order confirmation page
        echo "<script>alert('Order confirmed!'); window.location.href = '/tile2/index.php';</script>";
        exit;
    } else {
        // Handle insufficient stock and show specific product names
        $insufficientProducts = implode(", ", $insufficientStockItems);
        echo "<script>alert('Insufficient stock for the following items: $insufficientProducts. Please adjust your quantities.'); window.location.href = 'checkout.php';</script>";
        exit;
    }
}

include 'checkout.html';
?>
