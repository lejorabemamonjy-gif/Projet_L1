<?php

include "../config.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM utilisateur WHERE id_utilisateur = ?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$id]);
}

header("Location: users.php");
exit;

?>