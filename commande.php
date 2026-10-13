<?php
session_start();
require 'bd.php';
$bdd = getBD();

if (!isset($_SESSION['client']) || empty($_SESSION['panier'])) {
    header('Location: index.php');
    exit();
}

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

$adresse = isset($_SESSION['client']['adresse']) ? $_SESSION['client']['adresse'] : '';
if ($adresse == '') {
    $adresse = "Adresse non renseignée";
}

$token = generer_token_csrf();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande - SKI700</title>
    <link rel="stylesheet" href="styles/style1.css" type="text/css" media="screen" >
</head>
<body>
    <h1>Récapitulatif de votre commande</h1>

    <table class="tableau-principal">
        <tr>
            <th>Nom de l'article</th>
            <th>Quantité</th>
            <th>Sous-total</th>
        </tr>
        
        <?php
        $montant_total = 0;

        foreach ($_SESSION['panier'] as $article_panier) {
            $id = $article_panier['id_art'];
            $qte = $article_panier['quantite'];
            
            $infos_bd = isset($articles_bd[$id]) ? $articles_bd[$id] : null;
            
            if ($infos_bd) {
                $sous_total = $infos_bd['prix'] * $qte;
                $montant_total += $sous_total;
                
                echo '<tr>';
                echo '<td>' . htmlspecialchars($infos_bd['nom']) . '</td>';
                echo '<td>' . $qte . '</td>';
                echo '<td><strong class="prix-sous-total">' . number_format($sous_total, 2, ',', ' ') . ' €</strong></td>';
                echo '</tr>';
            }
        }
        ?>
    </table>

    <div class="boite-recapitulatif">
        <p class="recap-montant">Montant de votre commande : <br>
            <span class="texte-accent"><?php echo number_format($montant_total, 2, ',', ' '); ?> €</span>
        </p>
        
        <hr>
        
        <p class="texte-gris">La commande sera expédiée à l’adresse suivante :</p>
        <p class="adresse-nom">
            <?php echo htmlspecialchars($_SESSION['client']['nom']) . ' ' . htmlspecialchars($_SESSION['client']['prenom']); ?>
        </p>
        <p class="adresse-detail">
            <?php echo nl2br(htmlspecialchars($adresse)); ?>
        </p>
    </div>

    <div class="conteneur-bouton-action">
        <a href="acheter.php?csrf_token=<?php echo $token; ?>" class="btn-action-principal">Valider</a>
        <br>
        <a href="index.php" class="lien-retour">⬅ Retour à l'accueil</a>
    </div>

</body>
</html>