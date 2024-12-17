<?php
session_start();
include('server/connexion.php');

if(isset($_SESSION['logged_in'])){
  header('location: home.php');
  exit;
}

if(isset($_POST['login_page'])){
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $mysqli->prepare("SELECT user_id, name, email, password FROM users WHERE email = ? LIMIT 1");

  if($stmt){
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows == 1){
      $stmt->bind_result($user_id, $name, $email, $hashed_password);
      $stmt->fetch();

      if(password_verify($password, $hashed_password)){
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['logged_in'] = true;

        // Set success notification
        $_SESSION['notification'] = "Vous avez été connecté avec succès.";
        $_SESSION['notification_type'] = "success";

        header('Location: home.php');
      
        exit();
      } else {
        // Set error notification for incorrect password
        $_SESSION['notification'] = "Mot de passe incorrect";
        $_SESSION['notification_type'] = "error";

        header('location:login.php');
        exit;
      }
    } else {
      // Set error notification for account not found
      $_SESSION['notification'] = "Compte non trouvé";
      $_SESSION['notification_type'] = "error";

      header('location:login.php');
      exit;
    }
  } else {
    // Set error notification for query preparation error
    $_SESSION['notification'] = "Erreur de préparation de la requête";
    $_SESSION['notification_type'] = "error";

    header('location:login.php');
    exit;
  }
}


// Check if there is a notification to display
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
    <title>Match your Coffee- Login</title>
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

<body class="register">
<div id="notification-container"></div>

    <header class="header">
    <?php include('nav.php');?>

    </header>

    <main>


        <!--home-->
        <div class="main-container">
            <section class="form-container">
                <div class="title">
                    <img src="assets/logo.png" alt="logo">
                    <h1>Connectez-Vous</h1>
                    <p>Bienvenue sur notre plateforme </p>


                </div>
                <form action="" method="post">

                    <div class="input-filed">
                        <p> email <sup>*</sup> </p>
                        <input type="email" name="email" required placeholder="Entrez votre email">
                    </div>
                    <div class="input-filed">
                        <p> Mot de passe<sup>*</sup> </p>
                        <input type="password" name="password" required placeholder="Entrez votre mot de passe">
                    </div>
                    <input type="submit" name="login_page" value="Connexion" class="btn">
                    <p>vous avez pas un compte ? <a href="register.php" class="conx"> S'inscrire </a></p>
                </form>
            </section>

        </div>
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