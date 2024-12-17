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
if(isset($_SESSION['notification'])){
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                showNotification("' . addslashes($_SESSION['notification']) . '", "' . $_SESSION['notification_type'] . '");
            });
          </script>';
    
    // Clear the notification after displaying it
    unset($_SESSION['notification']);
    unset($_SESSION['notification_type']);
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

                <h1> Match your Coffee</h1>
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

        <section class="sold">
            <div class="img-sold">
                <img src="assets/matcha4.webp" alt="sold">
                <div class="overlay">
                    <h2> -40% sur votre première commande</h2>
                </div>
            </div>
            <div class="text-sold">
                <h3> -40% sur votre première commande</h3>
                <p>Pour vous accueillir dans notre univers de saveurs, nous vous offrons une remise exceptionnelle de
                    40% sur votre première commande. C'est le moment idéal pour découvrir nos produits de matcha et de
                    café de qualité supérieure.</p>
                <p>Utilisez le code promo : WELCOME40 lors de votre commande pour bénéficier de cette offre exclusive.

                </p>
                <div class="button-container">
                    <a href="products.php">Profitez de l'Offre Maintenant</a>
                </div>
            </div>
        </section>
        <section>
            <div class="products-m">
                <?php include('server/get_products_m.php'); ?>
                <div class="center-text">
                    <h2>Nos Matcha</h2>

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
            <div class="btn-prod">
                <a href="matchas.php">Plus</a>
            </div>
            </div>
        </section>

        <section class="products-c">
            <?php include('server/get_products_c.php'); ?>
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
            <div class="btn-prod">
                <a href="coffes.php">Plus</a>
            </div>

        </section>
        <section class="products-s">
            <?php include('server/get_products_s.php'); ?>
            <div class="center-text">
                <h2>Nos sirops</h2>

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

            <div class="btn-prod">
                <a href="sirops.php">Plus</a>
            </div>
        </section>
        <section class="products-k">
            <?php include('server/get_products_k.php'); ?>
            <div class="center-text">
                <h2>Nos Kite Matcha</h2>

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
                                <input type="number" name="qty" value="1" required min="1" max="99" maxlength="2"
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

            <div class="btn-prod">
                <a href="kites.php">Plus</a>
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
        <section class="avis-container">
            <div class="title">
                <img src="assets/logo.png" alt="logo">
                <h1>
                    Avis de nos clients fidèles
                </h1>
                <p>Découvrez ce que nos clients fidèles disent de nous et de nos produits, et rejoignez la communauté
                    des amateurs de matcha et de café !</p>
            </div>
            <div class="container">

                <div class="avis-item active">
                    <img src="assets/user.jpg" alt="user">
                    <h1>Sophie Martin</h1>
                    <p> J'adore le site Match Your Coffee ! La navigation est facile et j'ai toujours trouvé des
                        produits de qualité. Le matcha est incroyable, et je ne peux plus m'en passer !</p>
                </div>
                <div class="avis-item">
                    <img src="assets/user.jpg" alt="user">
                    <h1>Julien Dupont</h1>
                    <p>Le café que j'ai commandé était tout simplement délicieux. La livraison a été rapide et le
                        service client est très réactif. Je recommande vivement ce site à tous les amateurs de café !
                    </p>
                </div>
                <div class="avis-item">
                    <img src="assets/user.jpg" alt="user">
                    <h1> Claire Lefèvre</h1>
                    <p> Match Your Coffee propose une sélection exceptionnelle de produits. J'ai essayé leur café et
                        leur matcha, et les deux étaient d'une qualité remarquable. Je suis devenue une cliente fidèle !
                    </p>
                </div>
                <div class="avis-item">
                    <img src="assets/user.jpg" alt="user">
                    <h1> Marc Petit</h1>
                    <p> Je suis très satisfait de mes achats sur Match Your Coffee. Les descriptions des produits sont
                        précises, et j'apprécie les conseils sur la préparation. Un excellent rapport qualité-prix !</p>
                </div>
                <div class="avis-item">
                    <img src="assets/user.jpg" alt="user">
                    <h1>Émilie Rousseau</h1>
                    <p>Le site est très bien conçu et facile à utiliser. J'ai été impressionnée par la rapidité de la
                        livraison et la qualité des produits. Je n'hésiterai pas à recommander Match Your Coffee à mes
                        amis !</p>
                </div>
                <div class="left-arrow" onclick="nextSlide()"> <i class="ri-arrow-left-line"></i>
                </div>
                <div class="right-arrow" onclick="prevSlide()"><i class="ri-arrow-right-line"></i></div>

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