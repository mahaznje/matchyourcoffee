<?php 
include('connexion.php');
 $stmt = $mysqli->prepare("SELECT * FROM products WHERE type = 'kite' ");
 $stmt->execute();
 $featured_product = $stmt->get_result();

?>