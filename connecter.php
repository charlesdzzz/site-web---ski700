<?php
session_start();

require 'bd.php';
$bdd = getBD();
$token_recu = isset($_GET['csrf_token']) ? $_GET['csrf_token'] : '';
verifier_token_csrf($token_recu);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion en cours...</title>
    
    <?php
    if (isset($_GET['mail']) && isset($_GET['mdp'])) {
        
        $mail = $_GET['mail'];
        $mdp = $_GET['mdp'];

        $requete = $bdd->prepare('SELECT * FROM Clients WHERE mail = ?');
        $requete->execute([$mail]);
        $client = $requete->fetch();

        if ($client && password_verify($mdp, $client['mdp'])) {
            
            $_SESSION['client'] = array(
                'id_client' => $client['id_client'],
                'nom'       => $client['nom'],
                'prenom'    => $client['prenom'],
                'adresse'   => $client['adresse'],
                'numero'    => $client['numero'],
                'mail'      => $client['mail']
            );
            
            echo '<meta http-equiv="refresh" content="0;url=index.php">';
            
        } else {
            echo '<meta http-equiv="refresh" content="0;url=connexion.php">';
        }
        
    } else {
        echo '<meta http-equiv="refresh" content="0;url=connexion.php">';
    }
    ?>
</head>
<body>
    <p>Authentification en cours...</p>
</body>
</html>