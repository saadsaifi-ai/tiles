<?php

require_once('/var/www/html/tile2/config/DBconection.php');

class OrderManager {
    private $dbh;

    public function __construct() {
        $db = new DBconection();
        $this->dbh = $db->dbh;
    }

    public function getAllOrders() {
        $query = "SELECT orders.id, users.name AS username, orders.bill
                  FROM orders
                  JOIN users ON orders.user_id = users.id";
        $result = mysqli_query($this->dbh, $query);
        $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $orders;
    }

    public function getOrderItems($orderId) {
        $query = "SELECT products.name, order_items.quantity, order_items.price
                  FROM order_items
                  JOIN products ON order_items.product_id = products.id
                  WHERE order_items.order_id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, 'i', $orderId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $items;
    }

    public function deleteOrder($orderId) {
        $query = "DELETE FROM orders WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, 'i', $orderId);
        return mysqli_stmt_execute($stmt);
    }
}
