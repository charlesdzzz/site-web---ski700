<?php
session_start();
require '../bd.php';
$bdd = getBD(); 

$token_recu = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
verifier_token_csrf($token_recu);

if (!isset($_SESSION['client'])) {
    header('Location: ../index.php');
    exit();
}
$id_client = $_SESSION['client']['id_client'];

$bdd->query("DELETE FROM reservations WHERE expiration < NOW()");

if (isset($_POST['id_art']) && isset($_POST['quantite'])) {
    
    $id_article = $_POST['id_art'];
    $quantite_demandee = intval($_POST['quantite']);
    
    $qte_actuelle = 0;
    if (isset($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $article) {
            if ($article['id_art'] == $id_article) {
                $qte_actuelle = $article['quantite'];
                break;
            }
        }
    }
    $qte_totale = $qte_actuelle + $quantite_demandee;

    $req_stock = $bdd->prepare("SELECT quantite FROM article WHERE id_art = ?");
    $req_stock->execute([$id_article]);
    $stock_reel = $req_stock->fetchColumn();

    $req_reserve = $bdd->prepare("SELECT SUM(quantite) FROM reservations WHERE id_art = ? AND id_client != ?");
    $req_reserve->execute([$id_article, $id_client]);
    $stock_bloque = $req_reserve->fetchColumn();
    if (!$stock_bloque) $stock_bloque = 0;
    
    $stock_disponible = $stock_reel - $stock_bloque;

    if ($qte_totale <= $stock_disponible) {
        
        $nouvel_article = array('id_art' => $id_article, 'quantite' => $qte_totale);

        if ($qte_actuelle == 0) {
            if (!isset($_SESSION['panier'])) $_SESSION['panier'] = [];
            $_SESSION['panier'][] = $nouvel_article;
        } else {
            foreach ($_SESSION['panier'] as &$article) {
                if ($article['id_art'] == $id_article) {
                    $article['quantite'] = $qte_totale;
                    break;
                }
            }
        }

        $req_reservation = $bdd->prepare("REPLACE INTO reservations (id_client, id_art, quantite, expiration) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE))");
        $req_reservation->execute([$id_client, $id_article, $qte_totale]);

        $_SESSION['expiration_panier'] = time() + (5 * 60);
        
        header("Location: ../panier.php");
        exit();
    } else {
        header("Location: ../panier.php?erreur=stock");
        exit();
    }
}
header("Location: ../index.php");
exit();	