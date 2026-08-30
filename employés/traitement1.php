<?php 
if (isset($_POST['prix']) && $_POST['prix'] != "") {

    $route = $_POST['ligne'];
    $prix = $_POST['prix'];

    $conn = new mysqli('localhost', 'root', '', 'tbn');

    if ($conn->connect_error) {
        die("Erreur : " . $conn->connect_error);
    }

    $conn->query("INSERT INTO route (nom_route, prix)
                  VALUES ('$route', '$prix')");

    $id_route = $conn->insert_id;

    header('Location: reglage_voiture.php?id=' . $id_route);
    exit;
}
?>