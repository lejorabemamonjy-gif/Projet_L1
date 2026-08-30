<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé");
}

$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur: " . $conn->connect_error);
}

// Désactiver contraintes
$conn->query("SET FOREIGN_KEY_CHECKS=0");

// Reset des tables (ordre important)
$conn->query("TRUNCATE TABLE formulaire");
$conn->query("TRUNCATE TABLE reservation");
$conn->query("TRUNCATE TABLE trajet");
$conn->query("TRUNCATE TABLE route");
$conn->query("TRUNCATE TABLE voiture");

// Réactiver contraintes
$conn->query("SET FOREIGN_KEY_CHECKS=1");

// redirection
header("Location: reset.php?verif=1");
exit();
?>

