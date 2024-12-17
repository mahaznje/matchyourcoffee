<?php
session_start();
include('connexion.php');
if (isset($_POST['annuler']) && isset($_POST['command_id'])) {
    $commande_id = $_POST['command_id'];
    
    // Vérifiez le statut de la commande
    $stmt = $mysqli->prepare("SELECT status FROM orders WHERE `id` = ?");
    $stmt->bind_param("i", $commande_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
        
    if ($row && $row['status'] == 'En attente') {
        // Commencez une transaction
        $mysqli->begin_transaction();

        try {
            // Supprimez d'abord les détails de la commande
            $stmt = $mysqli->prepare("DELETE FROM order_details WHERE `order_id` = ?");
            $stmt->bind_param("i", $commande_id);
            $stmt->execute();
            
            // Ensuite, supprimez la commande
            $stmt = $mysqli->prepare("DELETE FROM orders WHERE `id` = ?");
            $stmt->bind_param("i", $commande_id);
            $stmt->execute();
            
            // Si tout s'est bien passé, validez la transaction
            $mysqli->commit();
            $_SESSION['message'] = "La commande a été annulée avec succès.";
        } catch (Exception $e) {
            // En cas d'erreur, annulez la transaction
            $mysqli->rollback();
            $_SESSION['message'] = "Une erreur est survenue lors de l'annulation de la commande.";
        }
    } else {
        $_SESSION['message'] = "La commande ne peut plus être annulée ou n'existe pas.";
    }
} else {
    $_SESSION['message'] = "Erreur: Données de commande non fournies.";
}

// Redirigez l'utilisateur vers la page des commandes
header('Location: /match_your_coffee/user_page.php');
exit();
?>
