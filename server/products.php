<?php 
include('connexion.php');
 $stmt = $mysqli->prepare("SELECT * FROM products ");
 $stmt->execute();
 $featured_product = $stmt->get_result();

?>