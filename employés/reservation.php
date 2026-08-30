<?php
session_start();
include('../stockage/HeaderOption.php');

// 🔐 PROTECTION ACCÈS
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'employe'])) {
    die("⛔ Accès refusé");
}

$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur de connexion");
}
?>
<link rel="stylesheet" href="stylereservation.css">
<h1>📋 Toutes les réservations</h1>

<?php
$sql = "
SELECT r.*, u.nom, u.prenom, t.jour, t.heure, v.matricule
FROM reservation r
JOIN utilisateur u ON r.id_utilisateur = u.id_utilisateur
JOIN trajet t ON r.id_trajet = t.id_trajet
JOIN voiture v ON t.id_voiture = v.id_voiture
ORDER BY r.created_at DESC
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

        echo "
        <div style='border:1px solid #ccc; padding:10px; margin:10px; border-radius:10px'>

            <p><b>Client :</b> ".$row['nom']." ".$row['prenom']."</p>
            <p><b>Jour :</b> ".$row['jour']."</p>
            <p><b>Heure :</b> ".$row['heure']."</p>
            <p><b>Voiture :</b> ".$row['matricule']."</p>
            <p><b>Date réservation :</b> ".$row['created_at']."</p>

        </div>
        ";
    }

} else {
    echo "<p>Aucune réservation</p>";
}
?>



<?php include('../stockage/footer.php'); ?>