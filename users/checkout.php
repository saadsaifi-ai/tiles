<?php
require_once "cart_operations.php";

$cartOps = new CartOperations();
$user_id = $_SESSION['id']; 

$cartItems = $cartOps->getCartItems($user_id);
$total = $cartOps->getCartTotal($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    
    if (empty($contact) || !ctype_digit($contact)) {
        echo "<script>alert('Please enter a valid contact number.'); window.location.href = 'checkout.php';</script>";
        exit;
    }

    if (empty($address)) {
        echo "<script>alert('Please enter a valid address.'); window.location.href = 'checkout.php';</script>";
        exit;
    }
    
    $insufficientStockItems = [];

    foreach ($cartItems as $item) {
        $availableStock = $cartOps->getProductStock($item['product_id']);
        if ($item['quantity'] > $availableStock) {
            $insufficientStockItems[] = $item['name'];
    }

    if (empty($insufficientStockItems)) {

        $order_id = $cartOps->createOrder($user_id, $total);
        $cartOps->createOrderItems($order_id, $cartItems);
        $cartOps->saveUserDetails($user_id, $order_id, $contact, $address);
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
