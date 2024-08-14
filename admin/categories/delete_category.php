<?php

require "CategoryOperations.php";

$categoryOps = new CategoryOperations();
$categoryOps->deleteCategory($_GET['id']);

header("Location: categories.php");
exit();
?>
