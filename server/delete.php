<?php 
  
  function deleteWishlist($mysqli, $wishlist_id) {
    
    // Vérifier si l'élément existe
    $verify_delete_items = $mysqli->prepare("SELECT * FROM wishlist WHERE id = ?");
    $verify_delete_items->bind_param("i", $wishlist_id);
    $verify_delete_items->execute();
    $result = $verify_delete_items->get_result();

    if($result->num_rows > 0){
        // L'élément existe, on peut le supprimer
        $delete_wishlist_id = $mysqli->prepare("DELETE FROM wishlist WHERE id = ?");
        $delete_wishlist_id->bind_param("i", $wishlist_id);
        if($delete_wishlist_id->execute()){
            return ['info' => true, 'message' => 'Produit effacé de la wishlist'];

        } else {
            return ['success' => false, 'message' => 'Erreur lors de la suppression du produit : ' . $mysqli->error];

        }
        $delete_wishlist_id->close();
    } else {
        return ['success' => false, 'message' => 'Produit non trouvé dans la wishlist' ];

    }

    $verify_delete_items->close();
}

function deleteCart($mysqli, $cart_id) {
    
    // Vérifier si l'élément existe
    $verify_delete_items = $mysqli->prepare("SELECT * FROM cart WHERE id = ?");
    $verify_delete_items->bind_param("i", $cart_id);
    $verify_delete_items->execute();
    $result = $verify_delete_items->get_result();

    if($result->num_rows > 0){
        // L'élément existe, on peut le supprimer
        $delete_cart_id = $mysqli->prepare("DELETE FROM cart WHERE id = ?");
        $delete_cart_id->bind_param("i", $cart_id);
        if($delete_cart_id->execute()){
            return ['info' => true, 'message' => 'Produit effacé de la cart'];

        } else {
            
            return ['success' => false, 'message' => 'Erreur lors de la suppression du produit: ' . $mysqli->error];
        }
        $delete_cart_id->close();
    } else {
        return ['success' => false, 'message' => 'Produit non trouvé dans la cart' ];

    }

    $verify_delete_items->close();
}





?>