<?php
session_start();

require 'bd.php';
$bdd = getBD();

$token_recu = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
verifier_token_csrf($token_recu);

if(!isset($_SESSION['client'])){
    header("Location: index.php");
    exit();
}

if(!isset($_POST["id"])){
    header("Location: panier.php");
    exit();
}

$id = $_POST["id"];

if(isset($_SESSION["panier"])){
    foreach($_SESSION["panier"] as $i => $article){
        if($article["id_art"] == $id){ 
            unset($_SESSION["panier"][$i]);
    
            // On libère l'article pour les autres clients
            $req_suppr = $bdd->prepare("DELETE FROM reservations WHERE id_client = ? AND id_art = ?");
            $req_suppr->execute([$_SESSION['client']['id_client'], $id]);
        }
    }
    // On réindexe le tableau pour éviter les "trous" dans les clés
    $_SESSION["panier"] = array_values($_SESSION["panier"]); 
}

header("Location: panier.php");
exit();