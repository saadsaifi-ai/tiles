<?php
require_once 'OrderManager.php';

if (!isset($_GET['order_id'])) {
    die('Order ID is required.');
}

$orderId = $_GET['order_id'];
$orderManager = new OrderManager();
$orderItems = $orderManager->getOrderItems($orderId);

include 'view_orders.html';
?>


