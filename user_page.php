<?php
session_start();
include('server/connexion.php');

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



?>




<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">
    <title>Compte Utilisateur</title>

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

    <header class="header">
        <?php include('nav.php');?>

    </header>
    <main class="main">
        <section class="user-section">
            <div class="user-container">
                <div class="user-info">
                    <h3>Espace utilisateur</h3>
                    <hr>
                    <div class="account-info" id="account-info">
                        <p>Nom : <?php if(isset($_SESSION['name'])){ echo $_SESSION['name'];} ?></p>
                        <p>E-mail : <?php if(isset($_SESSION['email'])){ echo $_SESSION['email'];} ?></p>
                        <form method="POST">
                            <button type="submit" name="logout" class="logout-btn">Déconnexion</button>
                        </form>
                    </div>
                </div>

                <div class="user-orders">
                    <h3>Vos commandes</h3>
                    <hr>
                    <div class="order-tables">
                        <?php 
                    
$user_id = $_SESSION['user_id'];$query_commandes = "SELECT o.* FROM orders o
WHERE o.user_id = ?
ORDER BY o.date DESC";
$stmt = $mysqli->prepare($query_commandes);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_commandes = $stmt->get_result();

if ($result_commandes && $result_commandes->num_rows > 0) {
?>
                        <table class="command-table">
                            <tr>
                                <th>N° de commande</th>
                                <th>Date de commande</th>
                                <th>Status</th>
                                <th>Total payé</th>
                            </tr>
                            <?php while ($commande = $result_commandes->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $commande['id']; ?></td>
                                <td><?php echo $commande['date']; ?></td>
                                <td><?php echo $commande['status']; ?>
                                    <?php if ($commande['status'] == 'En attente') { ?>
                                    <form method="post" action="server/annuler_commande.php">
                                        <input type="hidden" name="command_id" value="<?php echo $commande['id']; ?>">
                                        <input type="submit" name="annuler" class="btn-annule"
                                            value="Annuler la commande">
                                    </form>
                                    <?php } ?>
                                </td>
                                <td><?php echo number_format($commande['total_amount'], 2); ?> CHF</td>
                            </tr>
                            <?php } ?>
                        </table>


                        <?php
    // Afficher les détails de chaque commande
    $result_commandes->data_seek(0);
    while ($commande = $result_commandes->fetch_assoc()) {
        $order_id = $commande['id'];
        $query_details = "SELECT od.*, p.name AS product_name, p.image
                          FROM order_details od
                          LEFT JOIN products p ON od.product_id = p.id
                          WHERE od.order_id = ?";
        $stmt_details = $mysqli->prepare($query_details);
        $stmt_details->bind_param("i", $order_id);
        $stmt_details->execute();
        $result_details = $stmt_details->get_result();
        ?>
                        <div class="commande">
                            <h2>Commande #<?php echo $order_id; ?></h2>
                            <table class="detail-table">
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Total</th>
                                </tr>
                                <?php while ($detail = $result_details->fetch_assoc()) { ?>
                                <tr>
                                    <td class="cmd-detail">
                                        <div
                                            onclick="window.location.href='product.php?id=<?php echo $detail['product_id']; ?>'">
                                            <img class="cmd-img" src="assets/matcha-coffee/<?php echo $detail['image']; ?>"
                                                alt="<?php echo $detail['product_name']; ?>">
                                        </div>
                                        <?php echo $detail['product_name']; ?>
                                    </td>
                                    <td><?php echo $detail['qty']; ?></td>
                                    <td><?php echo $detail['price']; ?> CHF</td>
                                    <td><?php echo $detail['price'] * $detail['qty']; ?> CHF</td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <?php
    }
} else {
    echo "<p>Aucune commande n'a été faite.</p>";
}
?>
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