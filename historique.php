<?php
session_start();
require 'bd.php';
$bdd = getBD();

if (!isset($_SESSION['client'])) {
    header('Location: index.php');
    exit();
}

$id_client = $_SESSION['client']['id_client']; 

$requete = $bdd->prepare('
    SELECT c.id_commande, c.id_art, a.nom, a.prix, c.quantite, c.envoi 
    FROM Commandes c 
    LEFT JOIN article a ON c.id_art = a.id_art 
    WHERE c.id_client = ? 
    ORDER BY c.id_commande DESC
');

$requete->execute([$id_client]);
$commandes = $requete->fetchAll(PDO::FETCH_ASSOC);

$requete->closeCursor();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des commandes - SKI700</title>
    <link rel="stylesheet" href="styles/style1.css" type="text/css" media="screen" >
</head>
<body>
    <h1>Historique de vos commandes</h1>

    <?php
    if (count($commandes) == 0) {
        echo '<p class="message-historique-vide">Vous n\'avez passé aucune commande pour le moment.</p>';
    } else {
        echo '<table class="tableau-principal">';
        echo '<tr>
                <th>N° Commande</th>
                <th>ID Article</th>
                <th>Nom de l\'article</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>État de la commande</th>
              </tr>';
        
        foreach ($commandes as $donnees) {
            
            if ($donnees['envoi'] == 1) {
                $etat = '<span class="etat-envoye">Envoyée !</span>';
            } else {
                $etat = '<span class="etat-preparation">En préparation...</span>';
            }
            
            echo '<tr>';
            echo '<td>#' . $donnees['id_commande'] . '</td>';
            echo '<td>' . $donnees['id_art'] . '</td>';
            
            $nom_article = $donnees['nom'] ? htmlspecialchars($donnees['nom']) : '<i>Article retiré du catalogue</i>';
            $prix_article = $donnees['prix'] ? $donnees['prix'] . ' €' : '-';
            
            echo '<td>' . $nom_article . '</td>';
            echo '<td>' . $prix_article . '</td>';
            echo '<td>' . $donnees['quantite'] . '</td>';
            echo '<td>' . $etat . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    ?>

    <a href="index.php" class="lieng">Retour à l'accueil</a>

</body>
</html>