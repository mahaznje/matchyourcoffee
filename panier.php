<?php
 include('server/connexion.php'); 
 include_once('server/ajout.php');
 include_once('server/delete.php');


 session_start();
if(isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];


}else{
  $user_id = '';
  header("location: login.php");

}
if(isset($_POST['logout'])) {
  session_destroy();
  header("location: login.php");
}

 // Effacer un élément de la cart
  
 if(isset($_POST['delete_item'])){
  
    $result = deleteCart($mysqli,$_POST['cart_id']);
    if (is_array($result) && isset($result['message'])) {
        $type = $result['info'] ? 'info' : 'error';
        echo '<script>document.addEventListener("DOMContentLoaded", function() { showNotification("' . addslashes($result['message']) . '", "' . $type . '"); });</script>';
  } else {
      echo "<script>document.addEventListener('DOMContentLoaded', function() { showNotification('Une erreur est survenue', 'error'); });</script>";
  }

   
}
if (isset($_POST['ajout_a_wishlist']) && isset($_SESSION['user_id'])) {
  $result = ajouterAWishlist($mysqli, $_SESSION['user_id'], $_POST['product_id']);
  if (is_array($result) && isset($result['message'])) {
      $type = $result['success'] ? 'success' : 'error';
      echo '<script>document.addEventListener("DOMContentLoaded", function() { showNotification("' . addslashes($result['message']) . '", "' . $type . '"); });</script>';
  } else {
      echo "<script>document.addEventListener('DOMContentLoaded', function() { showNotification('Une erreur est survenue', 'error'); });</script>";
  }
}

if (isset($_POST['ajout_a_panier']) && isset($_SESSION['user_id'])) {
  $result = ajouterAuPanier($mysqli, $_SESSION['user_id'], $_POST['product_id'], $_POST['qty']);
  if (is_array($result) && isset($result['message'])) {
      $type = $result['success'] ? 'success' : 'error';
      echo '<script>document.addEventListener("DOMContentLoaded", function() { showNotification("' . addslashes($result['message']) . '", "' . $type . '"); });</script>';
  } else {
      echo "<script>document.addEventListener('DOMContentLoaded', function() { showNotification('Une erreur est survenue', 'error'); });</script>";
  }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Match your Coffee-panier</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">

    <!--boxin-icon-link-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!--remix-icon-link-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <!--google font-icon-link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

</head>

<body>
    <div id="notification-container"></div>

    <header class="header">
        <?php include('nav.php');?>

    </header>

    <main class="main">
        <div class="wishlist-container">


            <section class="panier-section panier">
                <h1>Mon Panier</h1>
                <table>
    <tr>
        <th>Produit</th>
        <th>Detail</th>
        <th>Quantité</th>
        <th>Action</th>
    </tr>
    <?php 
    
    // Initialize grand total
    $grand_total = 0;

    // Fetch cart items and calculate grand total
    $select_cart = $mysqli->prepare("SELECT * FROM cart WHERE user_id = ?");
    $select_cart->bind_param("i", $user_id);
    $select_cart->execute();
    $result_cart = $select_cart->get_result();

    if($result_cart->num_rows > 0) {
        while($fetch_cart = $result_cart->fetch_assoc()) {
            $select_products = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
            $select_products->bind_param("i", $fetch_cart['product_id']);
            $select_products->execute();
            $result_products = $select_products->get_result();
            
            if($result_products->num_rows > 0) {
                $produit = $result_products->fetch_assoc();
                // Calculate total for each product
                $total_price = $produit['price'] * $fetch_cart['qty'];
                // Add to grand total
                $grand_total += $total_price;
                ?>
                <tr>
                    <td>
                        <div onclick="window.location.href='product.php?id=<?php echo htmlspecialchars($produit['id']) ?>'">
                            <img src="assets/matcha-coffee/<?php echo htmlspecialchars($produit['image']) ?>" alt="<?php echo htmlspecialchars($produit['name']) ?>">
                        </div>
                    </td>
                    <td>
                        <p><?php echo htmlspecialchars($produit['name']) ?></p>
                        <p><?php echo number_format($produit['price'], 2) ?> CHF</p>
                    </td>
                    <td>
                        <p><?php echo (int)$fetch_cart['qty'] ?></p>
                    </td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='cart_id' value='<?php echo (int)$fetch_cart['id'] ?>'>
                            <button type="submit" name="delete_item" class='btn3 btn-delete'>
                                <i class="ri-delete-bin-line"></i>
                            </button>
                            <input type='hidden' name='product_id' value='<?php echo (int)$produit['id'] ?>'>
                        </form>
                    </td>
                </tr>
                <?php
            }
            $select_products->close();
        }
    // Code promo logic
    if (isset($_POST['apply_promo'])) {
        if (!isset($_SESSION['promo_applied'])) { // Check if promo already applied
            $promo_code = trim($_POST['promo_code']);
            
            // Check if it's the user's first order
            $check_first_order = $mysqli->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
            $check_first_order->bind_param("i", $user_id);
            $check_first_order->execute();
            $result_first_order = $check_first_order->get_result();
            $first_order_count = $result_first_order->fetch_row()[0];

            if ($promo_code === 'WELCOME40' && $first_order_count == 0) {
                $_SESSION['promo_applied'] = true; 
                
                // Prepare success message
                echo '<script>document.addEventListener("DOMContentLoaded", function() { showNotification("Code promo appliqué ! Vous avez reçu une réduction de 40 %.", "success"); });</script>';
            } else {
                // Prepare error message
                echo '<script>document.addEventListener("DOMContentLoaded", function() { showNotification("Code promo invalide ou non éligible pour la réduction.", "error"); });</script>';
            }
        } else {
            // Promo already applied
            echo '<script>document.addEventListener("DOMContentLoaded", function() { showNotification("Vous avez déjà utilisé un code promo.", "error"); });</script>';
        }
    }
       

        ?>
        
        <!-- Display Grand Total and Promo Code Section -->
        <tr>
            <td colspan="1" style="text-align:left;"><strong>Code promo</strong></td>
            <td colspan="2" style="text-align:right;">
                <?php if (!isset($_SESSION['promo_applied'])): ?>
                <form action="" method="post">
                    <input type="text" class="code_promo" name="promo_code" placeholder="Entrez votre code promo" required>
                    <button type="submit" name="apply_promo" class="btn-apply">Appliquer le code</button>
                </form>
                <?php else: ?>
                <p style="color: green;">Code promo 40% appliqué avec succès !</p>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align:left;"><strong>Total:</strong></td>
            <td><strong><?php 
                if (isset($_SESSION['promo_applied'])) {
                    $_SESSION['grand_total'] = $grand_total * 0.60;
                    echo number_format($_SESSION['grand_total'], 2); 
                } else {
                    $_SESSION['grand_total'] = $grand_total;
                    echo number_format($_SESSION['grand_total'], 2); 
                }
            ?> CHF</strong></td>
            <td colspan="3" style="text-align:right;">
                <form action="checkout.php" method="post">
                    <button type="submit" class="btn-checkout">Commander</button>
                </form>  
            </td>
        </tr>

    <?php 
    } else {
        unset($_SESSION['promo_applied']);
        unset($_SESSION['grand_total']);
        
        echo '<tr><td colspan="4" class="empty-cart">Votre panier est vide.</td></tr>';
    } ?>
</table>



            </section>
            <section class="panier-section selection-section">
                <h1>Notre sélection pour vous</h1>

                <table class="selection-table">
                    <tr>
                        <th>Produit</th>
                        <th> Detail </th>
                    </tr>
                    <?php
                // Sélectionner les produits qui ne sont ni dans la wishlist ni dans le panier de l'utilisateur
                $query = "SELECT p.* FROM products p
                          WHERE p.id NOT IN (
                              SELECT product_id FROM wishlist WHERE user_id = ?
                              UNION
                              SELECT product_id FROM cart WHERE user_id = ?
                          )
                          ORDER BY RAND()
                          LIMIT 5"; // Limitez à 4 produits, par exemple

                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ii", $user_id, $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows > 0) {
                    while ($produit = $result->fetch_assoc()) {
                        ?>
                    <tr>
                        <td>
                            <div onclick="window.location.href='product.php?id=<?php echo $produit['id'] ?>'">
                                <img src="assets/matcha-coffee/<?php echo $produit['image'] ?>"
                                    alt="<?php echo $produit['name'] ?>">
                            </div>
                        </td>
                        <td>
                            <p><?php echo $produit['name'] ?></p>
                            <p><?php echo $produit['price'] ?> CHF</p>
                            <form method='post' action=''>
                                <input type='hidden' name='product_id' value='<?php echo $produit['id'] ?>'>
                                <button type="submit" name="ajout_a_wishlist" class='btn3 btn-delete'>
                                    <i class="ri-heart-line"></i>
                                </button>
                                <button type="submit" name="ajout_a_panier" class='btn3 btn-delete'>
                                    <i class="ri-shopping-cart-fill"></i>
                                </button>
                                <input type="number" value="1" name="qty" required min="1" max="99" maxlength="2"
                                    class="qty">
                            </form>
                        </td>

                    </tr>
                    <?php
                    }
                } else {
                    echo '<tr><td colspan="2" class="empty-cart">Aucune suggestion disponible pour le moment.</td></tr>';
                }
                $stmt->close();
                ?>
                </table>
            </section>
        </div>
        <section class="features">
            <div class="features-content">


                <div class="box">
                    <div class="f-icon">
                        <i class="ri-truck-fill"></i>
                    </div>
                    <div class="f-text">
                        <h6>Frais de port gratuits à partir de 30.-</h6>
                    </div>
                </div>
                <div class="box">
                    <div class="f-icon">
                        <i class="ri-customer-service-fill"></i>
                    </div>
                    <div class="f-text">
                        <h6>Garantie de remboursement de 30 jours</h6>
                    </div>
                </div>
                <div class="box">
                    <div class="f-icon">
                        <i class="ri-bank-card-fill"></i>
                    </div>
                    <div class="f-text">
                        <h6>Paiement à la livraison</h6>
                    </div>
                </div>
            </div>

        </section>
    </main>
    <footer class="footer">
        <div class="footer-content">
            <img src="assets/logo.png" alt="logo">
            <p>Découvrez le meilleur du matcha et du café, livrés directement chez vous !</p>
            <p><strong>Paiement à la Livraison Disponible !</strong></p>
        </div>

        <div class="footer-links">
            <ul>
                <li><a href="#about">À Propos</a></li>
                <li><a href="#shop">Boutique</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
        </div>

        <div class="footer-social">
            <a href="#" aria-label="Facebook"><i class="boxin-icon-link fa fa-facebook"></i></a>
            <a href="#" aria-label="Instagram"><i class="boxin-icon-link fa fa-instagram"></i></a>
            <a href="#" aria-label="Twitter"><i class="boxin-icon-link fa fa-twitter"></i></a>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Match Your Coffee. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>