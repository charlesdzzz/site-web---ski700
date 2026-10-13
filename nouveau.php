<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau Client - SKI700</title>
    <link rel="stylesheet" href="styles/style1.css" type="text/css" media="screen">
</head>
<body>
    <div class="form-container">
        <h1>Créer un compte</h1>
        
        <?php
        if (isset($_GET['erreur']) && $_GET['erreur'] == 'tel') {
            echo '<div class="message-erreur">Attention, le numéro de téléphone est invalide (chiffres uniquement, 10 maximum).</div>';
        }
        ?>
        
        <form action="enregistrement.php" method="get" autocomplete="off">
            <div class="form-groupe">
                <label for="n">Nom :</label>
                <input type="text" id="n" name="n" value="<?php if(isset($_GET['n'])) { echo htmlspecialchars($_GET['n']); } ?>" required>
            </div>
            
            <div class="form-groupe">
                <label for="p">Prénom :</label>
                <input type="text" id="p" name="p" value="<?php if(isset($_GET['p'])) { echo htmlspecialchars($_GET['p']); } ?>" required>
            </div>
            
            <div class="form-groupe">
                <label for="adr">Adresse :</label>
                <input type="text" id="adr" name="adr" value="<?php if(isset($_GET['adr'])) { echo htmlspecialchars($_GET['adr']); } ?>" required>
            </div>
            
            <div class="form-groupe">
                <label for="num">Numéro de téléphone :</label>
                <input type="number" id="num" name="num" value="<?php if(isset($_GET['num'])) { echo htmlspecialchars($_GET['num']); } ?>" required>
            </div>
            
            <div class="form-groupe">
                <label for="mail">Adresse e-mail :</label>
                <input type="email" id="mail" name="mail" value="<?php if(isset($_GET['mail'])) { echo htmlspecialchars($_GET['mail']); } ?>" required>
            </div>
            
            <div class="form-groupe">
                <label for="mdp1">Mot de passe :</label>
                <input type="password" id="mdp1" name="mdp1" required>
            </div>
            
            <div class="form-groupe">
                <label for="mdp2">Confirmer votre mot de passe :</label>
                <input type="password" id="mdp2" name="mdp2" required>
            </div>
            
            <input type="submit" value="S'inscrire" class="btn-submit">
        </form>
        
        <div class="retour-container">
            <a href="index.php" class="lien-retour">⬅ Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>