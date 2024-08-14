<?php

require "ProductOperations.php";

$productOps = new ProductOperations();
$productOps->deleteProduct($_GET['id']);

header("Location: products.php");
exit();
?>
