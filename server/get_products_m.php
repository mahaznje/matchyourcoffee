<?php 
include('connexion.php');
 $stmt = $mysqli->prepare("SELECT * FROM products WHERE type = 'matcha' Limit 4");
 $stmt->execute();
 $featured_product = $stmt->get_result();

?>