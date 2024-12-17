<?php
   
function ajouterAWishlist($mysqli, $user_id, $product_id) {
    $stmt_check = $mysqli->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt_check->bind_param("ii", $user_id, $product_id);
    $stmt_check->execute();
    $stmt_check->bind_result($product_count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($product_count > 0) {
        return ['success' => false, 'message' => 'le produit existe déjà dans la Wishlist'];

    }

    // Récupérer le prix du produit
    $stmt_price =  $mysqli->prepare("SELECT price FROM products WHERE id = ? LIMIT 1");
    $stmt_price->bind_param("i", $product_id);
    $stmt_price->execute();
    $stmt_price->bind_result($product_price);
    $stmt_price->fetch();
    $stmt_price->close();


    $insert_w = $mysqli->prepare("INSERT INTO wishlist (user_id, product_id, price) VALUES (?, ?, ?)");
    $insert_w->bind_param("iid", $user_id, $product_id, $product_price);
    if ($insert_w->execute()) {
        return ['success' => true, 'message' => 'Produit ajouté dans la Wishlist avec succès'];
    } else {
        return ['success' => false, 'message' => 'Erreur lors de l\'ajout du produit dans la Wishlist'];
    }
    $insert_w->close();
}


function ajouterAuPanier($mysqli, $user_id, $product_id, $qty) {
    // Vérifier si le produit est déjà dans le panier
    $stmt_c = $mysqli->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt_c->bind_param("ii", $user_id, $product_id);
    $stmt_c->execute();
    $stmt_c->bind_result($cart_count);
    $stmt_c->fetch();
    $stmt_c->close();

    if ($cart_count > 0) {
        return ['success' => false, 'message' => 'le produit existe déjà dans le panier'];
    }

    // Récupérer le prix du produit
    $stmt = $mysqli->prepare("SELECT price FROM products WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($product_price);
    $stmt->fetch();
    $stmt->close();

    // Insérer dans le panier
    $insert_c = $mysqli->prepare("INSERT INTO cart (user_id, product_id, price, qty) VALUES (?, ?, ?, ?)");
    $insert_c->bind_param("iidd", $user_id, $product_id, $product_price, $qty);

    if ($insert_c->execute()) {
        $insert_c->close();
        return ['success' => true, 'message' => 'Produit ajouté dans le panier avec succès'];
    } else {
        $insert_c->close();
        return ['success' => false, 'message' => 'Erreur lors de l\'ajout du produit dans le panier: ' . $mysqli->error];
    }
}

?>