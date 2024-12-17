<?php
session_start();
include('server/connexion.php'); 

if ($mysqli->connect_error) {
    die('Erreur de connexion à la base de données : ' . $mysqli->connect_error);
}

if (isset($_POST['inscrit_page'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirm_password'];

    if ($password != $confirmpassword) {
        $_SESSION['notification'] = "Les mots de passe ne sont pas compatibles.";
        $_SESSION['notification_type'] = "error";
        header('Location: register.php');
        exit();
    } else {
        $stmt1 = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE email=?");
        if ($stmt1) {
            $stmt1->bind_param('s', $email);
            $stmt1->execute();
            $stmt1->bind_result($num_rows);
            $stmt1->fetch();
            $stmt1->close();

            if ($num_rows != 0) {
                $_SESSION['notification'] = "L'adresse e-mail est déjà enregistrée";
                $_SESSION['notification_type'] = "error";
                header('Location: register.php');
                exit();
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt2 = $mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                if ($stmt2) {
                    $stmt2->bind_param('sss', $name, $email, $hashed_password);
                    if ($stmt2->execute()) {
                        $user_id = $mysqli->insert_id; // Get the auto-generated user_id
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['email'] = $email;
                        $_SESSION['name'] = $name;
                        $_SESSION['logged_in'] = true;
                        $_SESSION['notification'] = "Vous avez été enregistré avec succès.";
                        $_SESSION['notification_type'] = "success";
                        header('Location: home.php');
                        exit();
                    } else {
                        $_SESSION['notification'] = "Une erreur s'est produite lors de la création du compte.";
                        $_SESSION['notification_type'] = "error";
                        header('Location: register.php');
                        exit();
                    }
                } else {
                    $_SESSION['notification'] = "Erreur lors de la préparation de la requête d'insertion.";
                        $_SESSION['notification_type'] = "error";
                    header('Location: register.php');
                    exit();
                }
            }
        } else {
            $_SESSION['notification'] = "Erreur lors de la préparation de la requête d'insertion.";
            $_SESSION['notification_type'] = "error";
            header('Location: register.php');
            exit();
        }
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
        <meta name="viewport"content="width=device-width, initial-scale=1">
        <title>Match your Coffee- register</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/style2.css">

        <!--boxin-icon-link-->
        <link rel="stylesheet"
        href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
        <!--remix-icon-link-->
        <link  href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
        <!--google font-icon-link-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
      
    </head>
  <body  class="register">
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
                <h1>Créer un compte</h1>
                <p>Bienvenue sur notre plateforme ! Pour commencer votre aventure avec nous, veuillez remplir le formulaire d'inscription ci-dessous. </p>


              </div>
              <?php
    if(isset($_GET['error'])) {
        echo '<div class="error">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>

    <form action="" method="post">
    <div class="input-filed">
                   <p> Nom <sup>*</sup> </p>  <input type="text" name="name" required placeholder="Entrez votre nom"> 
                   </div>
                 <div class="input-filed">
                   <p> email <sup>*</sup> </p>
                    <input type="email" name="email" required placeholder="Entrez votre email">
                    </div>       <div class="input-filed">
                   <p> Mot de passe<sup>*</sup> </p>
        <input type="password" name="password" required placeholder="Entrez votre mot de passe">
        </div>       <div class="input-filed">
                   <p> confirmation mot de passe <sup>*</sup> </p>
        <input type="password" name="confirm_password" required placeholder="Confirmez votre mot de passe">
        </div>

        <input type="submit" name="inscrit_page" value="S'inscrire" class="btn">
        <p>vous avez un compte ? <a href="login.php" class="conx"> connexion </a></p> 
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

