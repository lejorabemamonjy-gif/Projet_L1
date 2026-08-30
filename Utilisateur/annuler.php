<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur connexion");
}

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: /Projet_L1/login.php?message=connexion_requise");
    exit();
}

$id_user = intval($_SESSION['id_utilisateur']);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("❌ ID invalide");
}


/* récupérer réservation + trajet */
$stmt = $conn->prepare("
    SELECT r.id_trajet, r.id_utilisateur, r.status, t.date_depart
    FROM reservation r
    JOIN trajet t ON r.id_trajet = t.id_trajet
    WHERE r.id_reservation = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$res = $stmt->get_result();
$data = $res->fetch_assoc();


/* réservation introuvable */
if (!$data) {
    die("❌ Réservation introuvable");
}


/* sécurité : vérifier que la réservation appartient à l'utilisateur */
if (intval($data['id_utilisateur']) !== $id_user) {
    die("❌ Vous n'êtes pas autorisé à annuler cette réservation.");
}


/* vérifier si elle est déjà annulée */
if ($data['status'] !== 'active') {
    die("❌ Cette réservation est déjà annulée.");
}


/* date départ */
$date_depart = $data['date_depart'];


/* vérifier le délai de 24h */

if (
    empty($date_depart) ||
    $date_depart == '0000-00-00 00:00:00'
) {

    $autorise = true;

} else {

    $depart = strtotime($date_depart);

    if (!$depart) {
        $autorise = true;
    } else {

        $diff = $depart - time();

        // Annulation autorisée uniquement si départ dans au moins 24h
        $autorise = ($diff >= 86400);
    }
}


/* blocage */
if (!$autorise) {
    die("❌ Annulation impossible : moins de 24h avant départ");
}


/* annulation */
$stmt = $conn->prepare("
    UPDATE reservation
    SET status = 'annulee'
    WHERE id_reservation = ?
    AND id_utilisateur = ?
    AND status = 'active'
");

$stmt->bind_param("ii", $id, $id_user);
$stmt->execute();

$stmt = $conn->prepare("
    UPDATE reservation_stat
    SET status = 'annulee'
    WHERE id_reservation = ?
    AND id_utilisateur = ?
    AND status = 'active'
");

$stmt->bind_param("ii", $id, $id_user);
$stmt->execute();


/* remettre une place disponible */
$stmt = $conn->prepare("
    UPDATE trajet
    SET places_disponibles = places_disponibles + 1
    WHERE id_trajet = ?
");

$stmt->bind_param("i", $data['id_trajet']);
$stmt->execute();


/* redirection */
header("Location: mes_reservation.php?msg=annulee");
exit();
?>