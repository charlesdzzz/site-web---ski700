<?php
function getBD() {
    $bdd = new PDO('mysql:host=localhost;dbname=SKI700;charset=utf8', 'root', 'root');
    return $bdd;
}

function generer_token_csrf() {
    if (!isset($_SESSION['csrf_tokens'])) {
        $_SESSION['csrf_tokens'] = [];
    }
    
    $nouveau_token = bin2hex(random_bytes(32));
    
    $_SESSION['csrf_tokens'][] = $nouveau_token;
    
    if (count($_SESSION['csrf_tokens']) > 3) {
        array_shift($_SESSION['csrf_tokens']);
    }
    
    return $nouveau_token;
}

function verifier_token_csrf($token_recu) {
    if (!isset($_SESSION['csrf_tokens']) || empty($token_recu) || !in_array($token_recu, $_SESSION['csrf_tokens'])) {	
        header("Location: index.php");
        exit();
    }
}
?>