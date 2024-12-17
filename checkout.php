<?php
session_start();
include 'server/connexion.php';

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if(isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}

if (isset($_POST['place_order'])) {
    // Retrieve user data from session or POST
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $address_type = $_POST['address_type'];
    $method = $_POST['payment_method'];

   

    // Récupérer les produits du panier
    $cart_query = $mysqli->prepare("SELECT * FROM cart WHERE user_id = ?");
    $cart_query->bind_param("i", $user_id);
    $cart_query->execute();
    $cart_result = $cart_query->get_result();

    if ($method === 'Paiement à la livraison') {
   

        // Prepare and execute the main order insertion query
        $date = date('Y-m-d H:i:s');
        $status = 'En attente';
        $total_amount =  $_SESSION['grand_total'];
          
        // Debugging output to check values before insertion
        var_dump($user_id, $name, $number, $email, $address, $address_type, $method, $total_amount);

        $order_query = $mysqli->prepare("INSERT INTO orders (user_id, name, number, email, address, address_type, method, total_amount, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$order_query) {
            die("Erreur lors de la préparation de la requête : " . htmlspecialchars($mysqli->error));
        }
    
    
            $order_query->bind_param("issssssdss", $user_id, $name, $number, $email, $address, $address_type, $method, $total_amount, $date, $status);
            
            if (!$order_query->execute()) {
                die("Erreur lors de l'exécution de la requête : " . $order_query->error);
            }
            
            $order_id = $mysqli->insert_id;
          

            // Insérer les détails de la commande
            while ($cart_item = $cart_result->fetch_assoc()) {
                $product_id = $cart_item['product_id'];
                $price = $cart_item['price'];
                $qty = $cart_item['qty'];

                // Insert order details
                $detail_query = $mysqli->prepare("INSERT INTO order_details (order_id, product_id, price, qty) VALUES (?, ?, ?, ?)");
                $detail_query->bind_param("iidi", $order_id, $product_id, $price, $qty);
                
                if (!$detail_query->execute()) {
                    die("Erreur lors de l'insertion des détails : " . $detail_query->error);
                }
            }
        
            // Vider le panier après la commande
            $clear_cart = $mysqli->prepare("DELETE FROM cart WHERE user_id = ?");
            $clear_cart->bind_param("i", $user_id);
            if (!$clear_cart->execute()) {
                die("Erreur lors de la suppression du panier : " . $clear_cart->error);
            }
        
            // Rediriger vers la page utilisateur
            header('Location: user_page.php');
            exit();
            unset($_SESSION['promo_applied']);
            unset($_SESSION['promo_total']);
        
    } else {
        // Si la méthode de paiement est 'Twint'
        header('Location: twint_payment.php');
        exit();
    }
}
?> 
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">
    <title>Vérification de la commande</title>

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

    <header class="header">
        <?php include('nav.php');?>

    </header>

    <main>
        <div class="main-container">
            <section class="form-container">
                <div class="title">
                    <img src="assets/logo.png" alt="logo">
                    <h1>Vérification de la commande</h1>
                </div>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Nom complet:</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="number">Numéro de téléphone:</label>
                        <input type="tel" id="number" name="number" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse:</label>
                        <input id="address" name="address" required>
                    </div>

                    <div class="form-group">
                        <label for="address_type">Type d'adresse:</label>
                        <select id="address_type" name="address_type" required>
                            <option value="Domicile">Domicile</option>
                            <option value="Bureau">Bureau</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>

                    <div class="payment-section">
                        <h5>Mode de paiement :</h5>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input id="radio" type="radio" name="payment_method" value="Twint" required> Twint
                            </label>
                            <label class="payment-option">
                                <input id="radio" type="radio" name="payment_method" value="Paiement à la livraison" required>
                                Paiement à la livraison
                            </label>
                        </div>
                        <button type="submit" name="place_order">Passer la commande</button>
                    </div>
                </form>
            </section>
        </div>

        <section class="icon-section">
            <div class="icons">
                <img src="assets/icon4.png" alt="icon1">
                <p>Matcha</p>
            </div>
            <div class="icons">
                <img src="assets/icon2.png" alt="icon1">
                <p>Coffee</p>
            </div>
            <div class="icons">
                <img src="assets/icon3.png" alt="icon1">
                <p>Kit Matcha</p>
            </div>
            <div class="icons">
                <img src="assets/icon1.png" alt="icon1">
                <p>sirops </p>
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