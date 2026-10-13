<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> SKI700 </title>
    <link rel="stylesheet" href="styles/style1.css" type="text/css" media="screen" >
</head>

<body>
<?php
require 'bd.php';
$bdd = getBD();
$reponse = $bdd->query('SELECT * FROM article');
?>

<h1> SKI700 </h1>

<div class="grille-articles">
    <?php
    while ($donnees = $reponse->fetch()) {
        echo '<div class="carte-article">';
        
        echo '<img src="' . $donnees['url_photo'] . '" width="150" height="200" alt="' . $donnees['nom'] . '">';
        
        echo '<table>';
        echo '<tr><th>Réf</th><td>' . $donnees['id_art'] . '</td></tr>';
        echo '<tr><th>Nom</th><td><a href="articles/article.php?id_art=' . $donnees['id_art'] . '">' . $donnees['nom'] . '</a></td></tr>';
        echo '<tr><th>Stock</th><td>' . $donnees['quantite'] . ' restants</td></tr>';
        echo '<tr><th>Prix</th><td><strong class="prix-article">' . $donnees['prix'] . '€</strong></td></tr>';
        echo '</table>';
        
        echo '</div>';
    }
    $reponse->closeCursor();
    ?>
</div>


<a href="contact/moi.html" class="lienc"> Contact </a>

<?php
if (!isset($_SESSION['client'])) {
    // Lien vers nouveau client
    echo '<a href="nouveau.php" class="lienc btn-pos-3">Nouveau Client</a>';
    // Lien vers connexion
    echo '<a href="connexion.php" class="lienc btn-pos-2">Se connecter</a>';
} else {
    echo '<div class="conteneur-bienvenue">';
    
    echo '<div class="badge-bienvenue">';
    echo '<span class="texte-bienvenue"> Bonjour, <strong class="nom-bienvenue">' . htmlspecialchars($_SESSION['client']['prenom']) . ' ' . htmlspecialchars($_SESSION['client']['nom']) . '</strong></span>';
    echo '</div><br>';
    
    // Lien vers panier
    echo '<a href="panier.php" class="lieng">Mon Panier</a><br>';
    
    // Lien vers historique
    echo '<a href="historique.php" class="lieng btn-pos-2">Historique des commandes</a><br>';
    
    // Lien vers déconnexion
    echo '<a href="deconnexion.php" class="lienc btn-pos-3">Se déconnecter</a>';
    
    echo '</div>';
}
?>
</body>
</html>