<?php
function getItemCounts($mysqli) {
    $wishlist_count = 0;
    $cart_count = 0;

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Compter les articles dans la wishlist
        $stmt_wishlist = $mysqli->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ?");
        $stmt_wishlist->bind_param("i", $user_id);
        $stmt_wishlist->execute();
        $stmt_wishlist->bind_result($wishlist_count);
        $stmt_wishlist->fetch();
        $stmt_wishlist->close();

        // Compter les articles dans le panier
        $stmt_cart = $mysqli->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
        $stmt_cart->bind_param("i", $user_id);
        $stmt_cart->execute();
        $stmt_cart->bind_result($cart_count);
        $stmt_cart->fetch();
        $stmt_cart->close();
    }

    return array('wishlist' => $wishlist_count, 'cart' => $cart_count);
}
?>