<?php 
 include('server/connexion.php'); 
 include_once('server/ajout.php');

 session_start();
if(isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];


}else{
  $user_id = '';
}
if(isset($_POST['logout'])) {
  session_destroy();
  header("location: login.php");
}

 // Effacer un élément de la cart
  

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
    <title>Match your Coffee</title>
    <link rel="stylesheet" href="css/style.css">
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

    <main>
        <!--home-->
        <section class="home">

            <div class="home-text">
                <h6> Votre boutique en ligne de vente des matcha et café Trendy</h6>

                <h1> Coffee-Match your Coffee</h1>
                <p id="brands">
                    Notre mission est de proposer une expérience unique qui allie la tradition du matcha japonais à la
                    richesse du café, offrant ainsi à nos clients une sélection de produits raffinés et authentiques.
                </p>
                <a href="products.php" class="btn"> Shop now <i class="ri-arrow-right-line"></i>
                </a>
            </div>
            <div class="background-image"></div>
            <div class="background-image"></div>
            <div class="slider-nav">

                <button class="prev">&#10094;</button>

                <button class="next">&#10095;</button>
            </div>
        </section>
        <section class="icon-section">
            <div class="icons"  onclick="location.href='matchas.php'">
                <img src="assets/icon4.png" alt="icon1">
                <p>Matcha</p>
            </div>
            <div class="icons" onclick="location.href='coffes.php'">
                <img src="assets/icon2.png" alt="icon1" >
                <p>Coffee</p>
            </div>
            <div class="icons" onclick="location.href='kites.php'">
                <img src="assets/icon3.png" alt="icon1">
                <p>Kit Matcha</p>
            </div>
            <div class="icons" onclick="location.href='sirops.php'">
                <img src="assets/icon1.png" alt="icon1">
                <p>sirops </p>
            </div>
        </section>

        <section class="products-c">
            <?php include('server/products_c.php'); ?>
            <div class="center-text">
                <h2>Nos caffé</h2>

            </div>
            <div class="n-product">
            <?php  
                if( !empty($featured_product)){
                while( $row =  $featured_product->fetch_assoc() ){  ?>
                <form action="" method="POST" class="box">

                    <div class="row">
                        <div class="row-img">
                            <img src="assets/matcha-coffee/<?php echo $row['image'];?>">
                        </div>
                        <h3><?php echo $row['name'];?></h3>
                        <div class="row-in">
                            <div class="row-left">

                                <a href="product.php?id=<?php echo $row['id']; ?>">
                                    <i class="ri-eye-fill"></i>
                                </a>
                                <input type="hidden" name="product_id" value="<?php echo $row['id'];?>">
                                <button type="submit" name="ajout_a_panier">
                                    <i class="ri-shopping-cart-fill"></i>

                                </button>
                                <button type="submit" name="ajout_a_wishlist">
                                    <i class="ri-heart-fill"></i>

                                </button>
                            </div>
                            <div class="row-right">
                                <h6> <?php echo $row['price']; ?>CHF </h6>
                                <input type="number" value="1" name="qty" required min="1" max="99" maxlength="2"
                                    class="qty">


                            </div>


                        </div>
                </form>


            </div>
            <?php }
                }else{
                  echo'<p classe="empty"> Aucun produit trouvé  </p>';
                }
                 ?>


            </div>

        </section>

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