<?php 
include('connexion.php');
 $stmt = $mysqli->prepare("SELECT * FROM products WHERE type = 'sirop' ");
 $stmt->execute();
 $featured_product = $stmt->get_result();

?>