<?php
session_start();
$conn = new mysqli('localhost','root','','tbn');
$id_user = $_SESSION['id_utilisateur'];
$id_trajet = $_POST['id_trajet'];
$places = $_POST['places'] ?? [];

if (count($places) == 0) {
    die("❌ Aucune place sélectionnée");
}

foreach ($places as $num_place) {

    // vérifier la disponibilité
    $check = $conn->query("
        SELECT * FROM reservation
        WHERE id_trajet='$id_trajet'
        AND num_place='$num_place'
        AND status='active'
    ");

    if ($check->num_rows == 0) {

        $conn->query("
            INSERT INTO reservation (id_utilisateur,id_trajet,num_place,status)
            VALUES ('$id_user','$id_trajet','$num_place','active')
        ");
    }
}

/* recalcul des places */
$conn->query("
UPDATE trajet
SET places_disponibles = (
    SELECT COUNT(*) FROM (
        SELECT * FROM reservation
        WHERE id_trajet='$id_trajet' AND status='active'
    ) AS tmp
)
WHERE id_trajet='$id_trajet'
");

header("Location: mes_reservation.php");
exit();
?>