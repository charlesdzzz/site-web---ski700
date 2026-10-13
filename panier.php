<?php
session_start();
require 'bd.php';
$bdd = getBD();

$bdd->query("DELETE FROM reservations WHERE expiration < NOW()");

$erreur_expiration = null;
if (isset($_SESSION['expiration_panier'])) {
    if (time() > $_SESSION['expiration_panier']) {
        unset($_SESSION['panier']);
        unset($_SESSION['expiration_panier']);
        $erreur_expiration = "Le temps de réservation de 5 minutes est écoulé. Votre panier a été vidé.";
    }
}

$token = generer_token_csrf();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="styles/style1.css" type="text/css" media="screen" >
</head>
<body>
    <h1>Contenu de votre panier</h1>

    <?php
    if ($erreur_expiration) {
        echo '<div class="message-erreur">' . $erreur_expiration . '</div>';
    } elseif (isset($_GET['erreur']) && $_GET['erreur'] == 'stock') {
        echo '<div class="message-erreur">Désolé, la quantité demandée dépasse le stock actuellement disponible (certains articles sont peut-être réservés par d\'autres clients).</div>';
    } elseif (!empty($_SESSION['panier']) && isset($_SESSION['expiration_panier'])) {
        echo '<div class="message-alerte-orange">⏳ Vos articles sont réservés jusqu\'à ' . date('H:i:s', $_SESSION['expiration_panier']) . '. Passé ce délai, ils seront remis en stock.</div>';
    }

    if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
        echo '<p class="message-panier-vide">Votre panier ne contient aucun article.</p>';
    } else {
        
        $ids = [];
        foreach ($_SESSION['panier'] as $article_panier) {
            $ids[] = $article_panier['id_art'];
        }
        
        $places = implode(',', array_fill(0, count($ids), '?'));
        
        $requete = $bdd->prepare("SELECT id_art, nom, prix FROM article WHERE id_art IN ($places)");
        $requete->execute($ids);
        
        $articles_bd = [];
        while ($produit = $requete->fetch(PDO::FETCH_ASSOC)) {
            $articles_bd[$produit['id_art']] = $produit;
        }
        $requete->closeCursor();
        
        echo '<table class="tableau-principal">';
        echo '<tr>
                <th>ID Article</th>
                <th>Nom</th>
                <th>Prix Unitaire</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Action</th>
              </tr>';
        
        $montant_total = 0;

        foreach ($_SESSION['panier'] as $article_panier) {
            
            $id = $article_panier['id_art'];
            $qte = $article_panier['quantite'];
            
            if (isset($articles_bd[$id])) {
                $infos_bd = $articles_bd[$id];
                $sous_total = $infos_bd['prix'] * $qte;
                $montant_total += $sous_total;
                
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . htmlspecialchars($infos_bd['nom']) . '</td>';
                echo '<td>' . $infos_bd['prix'] . ' €</td>';
                echo '<td>' . $qte . '</td>';
                echo '<td><strong class="prix-sous-total">' . $sous_total . ' €</strong></td>';
                echo '<td>
                        <form action="retirer.php" method="POST" class="form-retirer">
                            <input type="hidden" name="csrf_token" value="' . $token . '">
                            <input type="hidden" name="id" value="' . $id . '">
                            <button type="submit" class="btn-retirer">X</button>
                        </form>
                      </td>';
                echo '</tr>';
            }
        }
        
        echo '</table>';
        
        echo '<div class="boite-total">';
        echo 'Montant total de la commande : <br><strong class="prix-total">' . $montant_total . ' €</strong>';
        echo '</div>';
        
        echo '<a href="commande.php" class="lienc">Passer la commande</a>';
    }
    ?>
    
    <a href="index.php" class="lieng">Retour à l'accueil</a>
</body>
</html>