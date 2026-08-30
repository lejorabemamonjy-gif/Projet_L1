<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin() {
    if (!isset($_SESSION['id_utilisateur'])) {
        header("Location: /Projet_L1/login.php?message=connexion_requise");
        exit();
    }
}
?>