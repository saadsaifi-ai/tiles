<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'OrderManager.php';

$orderManager = new OrderManager();

if (isset($_POST['delete_order'])) {
    $orderId = $_POST['order_id'];
    if ($orderManager->deleteOrder($orderId)) {
        echo "<div class='alert alert-success'>Order deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting order.</div>";
    }

}

$orders = $orderManager->getAllOrders();

include 'manage_orders.html';
?>


