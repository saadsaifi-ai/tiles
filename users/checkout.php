<?php
require_once "cart_operations.php";

$cartOps = new CartOperations();
$user_id = $_SESSION['id']; 

$cartItems = $cartOps->getCartItems($user_id);
$total = $cartOps->getCartTotal($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $insufficientStockItems = [];

    foreach ($cartItems as $item) {
        $availableStock = $cartOps->getProductStock($item['product_id']);
        if ($item['quantity'] > $availableStock) {
            $insufficientStockItems[] = $item['name'];
    }

    if (empty($insufficientStockItems)) {

        $cartOps->saveUserDetails($user_id, $contact, $address);

        $order_id = $cartOps->createOrder($user_id, $total);
        $cartOps->createOrderItems($order_id, $cartItems);

        $cartOps->clearCart($user_id,$order_id);

        // Reset session variable for cart count
        $_SESSION['cart'] = [];

        echo "<script> alert('Order confirmed!'); window.location.href = '/tile2/index.php'; // Redirect to home or another page</script>";
        exit;
        
    } else {
        $insufficientProducts = implode(", ", $insufficientStockItems);
        echo "<script>alert('Insufficient stock for the following items: $insufficientProducts. Please adjust your quantities.'); window.location.href = 'checkout.php';</script>";
        exit;
    }
    }
}
include 'checkout.html';
?>
