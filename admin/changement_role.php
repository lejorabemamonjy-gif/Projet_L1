<?php
session_start();
include "../config.php";

/** @var PDO $pdo */

if ($_SESSION['role'] !== 'admin') {
    die("Accès refusé");
}

$id   = intval($_GET['id']   ?? 0);
$role = $_GET['role'] ?? '';

// Valider le rôle reçu
$roles_valides = ['client', 'employe', 'admin'];
if ($id <= 0 || !in_array($role, $roles_valides)) {
    die("❌ Paramètres invalides.");
}

// Un admin ne peut pas se rétrograder lui-même
if ($id === intval($_SESSION['id_utilisateur']) && $role !== 'admin') {
    die("❌ Vous ne pouvez pas modifier votre propre rôle d'administrateur.");
}

$sql  = "UPDATE utilisateur SET role = ? WHERE id_utilisateur = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$role, $id]);

header("Location: users.php");
exit();
