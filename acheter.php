<?php
session_start();
require 'bd.php';

$token_recu = isset($_GET['csrf_token']) ? $_GET['csrf_token'] : '';
verifier_token_csrf($token_recu);

$bdd = getBD();

if (!isset($_SESSION['client']) || empty($_SESSION['panier'])) {
    header('Location: index.php');
    exit();
}

$id_client = $_SESSION['client']['id_client']; 

// Vérification de l'expiration du panier
if (isset($_SESSION['expiration_panier']) && time() > $_SESSION['expiration_panier']) {
    // Le temps est écoulé pendant que le client était sur la page de commande
    $bdd->query("DELETE FROM reservations WHERE expiration < NOW()");
    unset($_SESSION['panier']);
    unset($_SESSION['expiration_panier']);
    
    header('Location: panier.php');
    exit();
}

// Validation de la commande
// On passe directement à l'insertion car les stocks sont garantis par la réservation
foreach ($_SESSION['panier'] as $article_panier) {
    $id_art = $article_panier['id_art'];
    $qte_commandee = $article_panier['quantite'];
    
    // Ajout dans l'historique des commandes
    $requete_commande = $bdd->prepare('INSERT INTO Commandes (id_art, id_client, quantite) VALUES (?, ?, ?)');
    $requete_commande->execute([$id_art, $id_client, $qte_commandee]);
    
    // Déduction définitive du vrai stock
    $requete_stock = $bdd->prepare('UPDATE article SET quantite = quantite - ? WHERE id_art = ?');
    $requete_stock->execute([$qte_commandee, $id_art]);
    
    // Suppression de la réservation tampon pour libérer la table
    $req_suppr_res = $bdd->prepare('DELETE FROM reservations WHERE id_client = ? AND id_art = ?');
    $req_suppr_res->execute([$id_client, $id_art]);
}

// On vide le panier et on supprime le chrono
unset($_SESSION['panier']);
unset($_SESSION['expiration_panier']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Merci pour votre achat - SKI700</title>
    <link rel="stylesheet" href="styles/style1.css" type="text/css" media="screen" >
</head>
<body>
    
    <div class="boite-recapitulatif boite-succes">
        <h1 class="titre-succes">Merci pour votre achat !</h1>
        
        <p class="message-succes">
            Votre commande a bien été enregistrée.
        </p>
        
        <p class="message-expedition">
            Vos articles seront préparés et expédiés très prochainement.
        </p>
    </div>

    <div class="conteneur-bouton-action">
        <a href="index.php" class="btn-action-principal">Retour à l'accueil</a>
    </div>

</body>
</html>