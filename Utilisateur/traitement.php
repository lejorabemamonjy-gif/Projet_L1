<?php
session_start();

$today = date('Y/m/d');

$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données.");
}

$id_user = $_SESSION['id_utilisateur'] ?? null;

if (!$id_user) {
    header("Location: login.php");
    exit();
}

$id_trajet = intval($_POST['id_trajet']);
$places = $_POST['places'] ?? [];

if (count($places) == 0) {
    die("❌ Aucune place sélectionnée.");
}

$places_reservees = 0;

foreach ($places as $p) {

    $p = intval($p);

    // Vérifier uniquement les réservations ACTIVES
    $stmt = $conn->prepare("
        SELECT id_reservation
        FROM reservation
        WHERE id_trajet = ?
        AND num_place = ?
        AND status = 'active'
        LIMIT 1
    ");

    $stmt->bind_param("ii", $id_trajet, $p);
    $stmt->execute();

    $check = $stmt->get_result();

    // Si aucune réservation active, on peut réserver
    if ($check->num_rows == 0) {

        $stmt = $conn->prepare("
            INSERT INTO reservation
            (id_utilisateur, id_trajet, num_place, status)
            VALUES (?, ?, ?, 'active')
        ");

        $stmt->bind_param(
            "iii",
            $id_user,
            $id_trajet,
            $p
        );

        if ($stmt->execute()) {
            $places_reservees++;
        }

        $stmt = $conn->prepare("
            INSERT INTO reservation_stat
            (id_utilisateur, id_trajet, num_place, status)
            VALUES (?, ?, ?, 'active')
        ");

        $stmt->bind_param(
            "iii",
            $id_user,
            $id_trajet,
            $p
        );

        if ($stmt->execute()) {
            $places_reservees++;
        }
    }
}


// Mettre à jour uniquement avec le nombre
// de places réellement réservées
if ($places_reservees > 0) {

    $stmt = $conn->prepare("
        UPDATE trajet
        SET places_disponibles =
            places_disponibles - ?
        WHERE id_trajet = ?
    ");

    $stmt->bind_param(
        "ii",
        $places_reservees,
        $id_trajet
    );

    $stmt->execute();
}


header("Location: mes_reservation.php");
exit();
?>