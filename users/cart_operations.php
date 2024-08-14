<?php

require_once('/var/www/html/tile2/config/DBconection.php');
require_once "../admin/products/ProductOperations.php";

class CartOperations {
    private $productOps;
    private $dbh;

    public function __construct() {
        $this->productOps = new ProductOperations();
        $db = new DBconection();
        $this->dbh = $db->dbh;
    }

    public function addToCart($user_id, $product_id, $quantity) {
        // Check if the product already exists in the cart
        $query = "SELECT id, quantity FROM qoutes WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $cartItem = mysqli_fetch_assoc($result);

        if ($cartItem) {
            // If the item exists, update the quantity
            $new_quantity = $cartItem['quantity'] + $quantity;
            $updateQuery = "UPDATE qoutes SET quantity = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($this->dbh, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ii", $new_quantity, $cartItem['id']);
            mysqli_stmt_execute($updateStmt);
        } else {
            // If the item does not exist, add it to the cart
            $query = "INSERT INTO qoutes (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($this->dbh, $query);
            mysqli_stmt_bind_param($stmt, "iii", $user_id, $product_id, $quantity);
            mysqli_stmt_execute($stmt);
        }
    }

    public function removeFromCart($product_id) {
        $query = "DELETE FROM qoutes WHERE product_id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
    }

    public function getCartItems($user_id) {
        $query = "SELECT qoutes.*, products.name, products.price, products.image 
                  FROM qoutes 
                  JOIN products ON qoutes.product_id = products.id 
                  WHERE qoutes.user_id = ?";
        $stmt = mysqli_prepare($this->dbh, $query); 
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCartTotal($user_id) {
        $query = "SELECT SUM(products.price * qoutes.quantity) AS total 
                  FROM qoutes 
                  JOIN products ON qoutes.product_id = products.id 
                  WHERE qoutes.user_id = ?";
        $stmt = mysqli_prepare($this->dbh, $query); 
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result)['total'];
    }

    
    // Save user details
    public function saveUserDetails($user_id, $contact, $address) {
        // Check if user details already exist
        $query = "SELECT id FROM user_details WHERE user_id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Update existing details
            $query = "UPDATE user_details SET contact = ?, address = ? WHERE user_id = ?";
            $stmt = mysqli_prepare($this->dbh, $query);
            mysqli_stmt_bind_param($stmt, "ssi", $contact, $address, $user_id);
        } else {
            // Insert new details
            $query = "INSERT INTO user_details (user_id, contact, address) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($this->dbh, $query);
            mysqli_stmt_bind_param($stmt, "iss", $user_id, $contact, $address);
        }
        mysqli_stmt_execute($stmt);
    }

    // Create order
    public function createOrder($user_id, $total) {
        $query = "INSERT INTO orders (user_id, bill) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "id", $user_id, $total);
        mysqli_stmt_execute($stmt);
        return mysqli_insert_id($this->dbh); // Return the order ID
    }

    public function createOrderItems($order_id, $cartItems) {
        // Prepare the query to insert order items
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->dbh, $query);
    
        // Loop through each cart item and insert it as an order item
        foreach ($cartItems as $item) {
            mysqli_stmt_bind_param($stmt, "iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
            mysqli_stmt_execute($stmt);
    
            // Now update the product's total quantity in the products table
            $updateQuery = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
            $updateStmt = mysqli_prepare($this->dbh, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ii", $item['quantity'], $item['product_id']);
            mysqli_stmt_execute($updateStmt);
        }
    }
    
    // Clear the cart
    public function clearCart($user_id) {
        $query = "DELETE FROM qoutes WHERE user_id = ?";
        $stmt = mysqli_prepare($this->dbh, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
    }

    public function updateCartQuantity( $product_id, $quantity) {
                echo("i am here");
                echo $product_id;
                echo $quantity;
            $updateQuery = "UPDATE qoutes SET quantity = ? WHERE product_id = ?";
            $updateStmt = mysqli_prepare($this->dbh, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ii", $quantity, $product_id );
            mysqli_stmt_execute($updateStmt);
        }

    public function getProductStock($product_id) {
            $query = "SELECT quantity FROM products WHERE id = ?";
            $stmt = mysqli_prepare($this->dbh, $query);
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $product = mysqli_fetch_assoc($result);
            return $product['quantity'];
        }


}






