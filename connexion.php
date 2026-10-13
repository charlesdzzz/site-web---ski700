<?php
session_start();
require 'bd.php';
$token = generer_token_csrf();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - SKI700</title>
    <link rel="stylesheet" href="styles/style1.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="form-container">
        <h1>Se connecter</h1>
        
        <?php
        if (isset($_GET['erreur'])) {
            echo '<div class="message-erreur">Identifiants incorrects. Veuillez réessayer.</div>';
        }
        ?>
        
        <form action="connecter.php" method="get" autocomplete="off">
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
            <div class="form-groupe">
                <label for="mail">Adresse e-mail :</label>
                <input type="email" id="mail" name="mail" required>
            </div>
            
            <div class="form-groupe">
                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" required>
            </div>
            
            <input type="submit" value="Se connecter" class="btn-submit">
        </form>

        <div class="inscription-container">
            <p>Vous n'avez pas encore de compte ?</p>
            <a href="nouveau.php" class="inscription-lien">Créer un compte client</a>
        </div>
        
        <div class="retour-container">
            <a href="index.php" class="lien-retour">⬅ Retour à l'accueil</a>
        </div>
    </div>

</body>
</html>