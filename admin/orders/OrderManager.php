<?php
require('/var/www/html/fpdf/fpdf.php');
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

    public function generatePDF() {
        $orders = $this->getAllOrders();

        // Create new PDF document
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set title
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(190, 10, 'Orders Report', 0, 1, 'C');

        // Set headers
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, 'ID', 1);
        $pdf->Cell(70, 10, 'Username', 1);
        $pdf->Cell(50, 10, 'Total Bill', 1);
        $pdf->Cell(60, 10, 'Order Items', 1);
        $pdf->Ln();

        // Populate table
        $pdf->SetFont('Arial', '', 12);
        foreach ($orders as $order) {
            $pdf->Cell(10, 10, $order['id'], 1);
            $pdf->Cell(70, 10, $order['username'], 1);
            $pdf->Cell(50, 10, $order['bill'], 1);

            // Get order items
            $items = $this->getOrderItems($order['id']);
            $itemList = "";
            foreach ($items as $item) {
                $itemList .= $item['name'] . ' x' . $item['quantity'] . ', ';
            }
            $itemList = rtrim($itemList, ', ');
            $pdf->Cell(60, 10, $itemList, 1);

            $pdf->Ln();
        }

        // Output the PDF
        $pdf->Output('D', 'orders_report.pdf');
    }
}
