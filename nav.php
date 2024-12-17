<?php include_once('server/count.php');

$counts = getItemCounts($mysqli);



 ?>

<img class="logo" src="assets/logo.png" alt="logo">
<ul class="navlist">
    <li><a href="home.php"> Accueil </a></li>
    <li><a href="products.php"> Boutique </a></li>
    <li><a href="home.php"> Contact </a></li>
</ul>
<div class="nav-right">

    <a href="wishlist.php"><i class="ri-heart-fill"></i> <sup><?php echo $counts['wishlist']; ?></sup></a>
    <a href="panier.php"> <i class="ri-shopping-cart-fill"></i> <sup><?php echo $counts['cart']; ?></sup></a>
    <a href="#"><i class="ri-user-fill" id="user-btn"></i></a>
    <div id="menu-icon" onclick="toggleMenu()">☰</div>

</div>
<div class="user-box">
    <?php if(isset($_SESSION['user_id'])) { ?>
    <p>username : <?php echo $_SESSION['name']; ?></p>
    <p>Email : <?php echo $_SESSION['email']; ?></p>
    <div class="user">
    <form method="POST">
        <button type="submit" name="logout" class="logout-btn">Déconnexion</button>
    </form>
    <form action="user_page.php">
        <button type="submit" class="logout-btn">Compte</button>

    </form>

    </div>
  
    <?php } else { ?>
    <a href="login.php" class="btn">connexion</a>
    <a href="register.php" class="btn">inscription</a>
    <?php } ?>
</div>