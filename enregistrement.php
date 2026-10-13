<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrement</title>
    
    <?php
    require 'bd.php';

    function enregistrer($nom, $prenom, $adresse, $mail, $numero, $mdp) {
        $bdd = getBD();
        $mdpHache = password_hash($mdp, PASSWORD_DEFAULT);
        $requete = $bdd->prepare('INSERT INTO Clients (nom, prenom, adresse, mail, numero, mdp) VALUES (?, ?, ?, ?, ?, ?)');
        $requete->execute([$nom, $prenom, $adresse, $mail, $numero, $mdpHache]);
    }   

    if (isset($_GET['n']) && isset($_GET['p']) && isset($_GET['adr']) && isset($_GET['num']) && isset($_GET['mail']) && isset($_GET['mdp1']) && isset($_GET['mdp2'])) {
        
        $n = $_GET['n'];
        $p = $_GET['p'];
        $adr = $_GET['adr'];
        $num = $_GET['num'];
        $mail = $_GET['mail'];
        $mdp1 = $_GET['mdp1'];
        $mdp2 = $_GET['mdp2'];

        if ($n == "" || $p == "" || $adr == "" || $num == "" || $mail == "" || $mdp1 == "" || $mdp2 == "" || $mdp1 != $mdp2) {
            
            echo '<meta http-equiv="refresh" content="0;url=nouveau.php?n=' . $n . '&p=' . $p . '&adr=' . $adr . '&num=' . $num . '&mail=' . $mail . '">';
            
        } elseif (!preg_match('/^[0-9]+$/', $num) || strlen($num) > 10) {
            
            echo '<meta http-equiv="refresh" content="0;url=nouveau.php?n=' . $n . '&p=' . $p . '&adr=' . $adr . '&num=' . $num . '&mail=' . $mail . '&erreur=tel">';
            
        } else {
            enregistrer($n, $p, $adr, $mail, $num, $mdp1);
            
            echo '<meta http-equiv="refresh" content="0;url=connexion.php">';
        }
        
    } else {
        echo '<meta http-equiv="refresh" content="0;url=nouveau.php">';
    }
    ?>
</head>
<body>
	<p class="message-redirection">Enregistrement et redirection en cours...</p>
</body>
</html>