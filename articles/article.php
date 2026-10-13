<?php
session_start();
require '../bd.php';
$bdd = getBD();

$id_article = $_GET['id_art'];

$requete = $bdd->prepare('SELECT * FROM article WHERE id_art = ?');
$requete->execute([$id_article]);
$donnees = $requete->fetch(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $donnees['nom']; ?> - SKI700</title>
    <link rel="stylesheet" href="../styles/style1.css" type="text/css" media="screen" >
</head>

<body>
    <h1><?php echo $donnees['nom']; ?></h1>
    
    <div class="fiche-produit">
		<div class="image-produit">
        <img src="../<?php echo $donnees['url_photo']; ?>" width="150" alt="<?php echo $donnees['nom']; ?>">
		</div>
		<div class="details-produit">
        <p><strong>Identifiant :</strong> <?php echo $donnees['id_art']; ?></p>
        <p><strong>Prix :</strong> <?php echo $donnees['prix']; ?> €</p>
        <p><strong>Stock :</strong> <?php echo $donnees['quantite']; ?> articles restants</p>
			<div class="description">
			<p><strong>Description :</strong> <?php echo $donnees['description']; ?></p>
			</div>
		</div>
	</div>
<?php
if (isset($_SESSION['client'])) {
    $id_de_l_article = $_GET['id_art']; 
    
    echo '<form action="ajouter.php" method="POST" class="panier">';
	
	$token = generer_token_csrf();
    echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
    
    echo '<input type="hidden" name="id_art" value="' . $id_de_l_article . '">';
    
    echo '<div class="quantite-groupe">';
    echo '<label for="qte">Quantité : </label>';
    echo '<input type="number" id="qte" name="quantite" value="1" min="1" required class="input-quantite">';
    echo '</div>';
    
    echo '<input type="submit" value="Ajouter au panier" class="btn-ajouter">';
    
    echo '</form>';
}
?>

    <a href="../index.php" class="lienc"> Retour </a>
</body>
</html>