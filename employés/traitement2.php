<?php

$id_route = $_GET['id'];

$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur : " . $conn->connect_error);
}

$heures = $_POST['heure'];
$matricules = $_POST['numv'];
$places = $_POST['place'];
$chauffeurs = $_POST['chauffeur'];
$copilotes = $_POST['copilote'];
$jours = $_POST['jour'];

for ($i = 0; $i < count($matricules); $i++) {

    $matricule = $matricules[$i];
    $nbr_place = $places[$i];
    $chauffeur = $chauffeurs[$i];
    $copilote = $copilotes[$i];
    $heure = $heures[$i];
    $jour = $jours[$i];

    // vérification des voitures
    $result = $conn->query("SELECT id_voiture FROM voiture WHERE matricule = '$matricule'");

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $id_voiture = $row['id_voiture'];

    } else {

        $conn->query("
            INSERT INTO voiture (matricule, chauffeur, copilote, nbr_place)
            VALUES ('$matricule', '$chauffeur', '$copilote', '$nbr_place')
        ");

        $id_voiture = $conn->insert_id;
    }

    // insertion du trajet
    $conn->query("
        INSERT INTO trajet (id_route, id_voiture, jour, heure, places_disponibles)
        VALUES ('$id_route', '$id_voiture', '$jour', '$heure', '$nbr_place')
    ");
}

header("Location: succes.php");
exit();
?>