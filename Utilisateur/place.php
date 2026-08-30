<?php
$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données.");
}

$id_trajet = isset($_GET['id_trajet']) ? intval($_GET['id_trajet']) : 0;

if ($id_trajet === 0) { 
    die("Trajet spécifié incorrect."); 
}

$query = $conn->query("SELECT t.*, v.nbr_place FROM trajet t JOIN voiture v ON t.id_voiture = v.id_voiture WHERE t.id_trajet = $id_trajet");
$trajet = $query->fetch_assoc();
$total = intval($trajet['nbr_place']);
?>

<!-- APPEL DU FICHIER CSS AVEC SÉCURITÉ ANTI-CACHE -->
<link rel="stylesheet" href="styleplace.css?v=<?= time(); ?>">

<div class="places-wrapper">

    <div class="page-title">
        <h1>Réservation des places</h1>
        <div class="title-underline"></div>
    </div>

    <!-- Légende descriptive -->
    <div class="legend">
        <div class="legend-item"><span class="legend-dot dot-free"></span> Libre</div>
        <div class="legend-item"><span class="legend-dot dot-occupied"></span> Occupé</div>
        <div class="legend-item"><span class="legend-dot dot-selected"></span> Réserver</div>
    </div>

    <!-- Silhouette Mercedes Crafter -->
    <div class="bus-body">
        
        <div class="bus-header">
            <p>Véhicule</p>
            <small>AVANT (PARE-BRISE)</small>
        </div>

        <div class="bus-interior">
            <form action="formulaire_reservation.php" method="POST">
                
                <input type="hidden" name="id_trajet" value="<?= $id_trajet ?>">

                <div class="bus-grid">

                    <div class="seat-driver-block">👨‍✈️ Conducteur</div>
                    <div class="seat seat-driver">🚫 Copilote</div>

                    <?php
                    // Les places 1 et 2 sont conducteur et copilote.
                    // La première place client stockée en base est donc la place 3.
                    for ($num_place = 3; $num_place <= $total; $num_place++) {

                        // Numéro affiché au client : 1, 2, 3...
                        $numero_affiche = $num_place - 2;

                        // Vérifie avec le vrai numéro de place de la base : 3, 4, 5...
                        $check = $conn->query("
                            SELECT 1 FROM reservation
                            WHERE id_trajet = $id_trajet
                            AND num_place = $num_place
                            AND status = 'active'
                            LIMIT 1
                        ");

                        if ($check && $check->num_rows > 0) {
                            echo "<div class='seat seat-occupied'>$numero_affiche</div>";
                        } else {
                            echo "
                            <label class='seat seat-available'>
                                <input type='checkbox' name='places[]' value='$num_place'>
                                $numero_affiche
                            </label>";
                        }
                    }
                    ?>

                </div>

                <button type="submit" class="btn-submit">Confirmer la sélection</button>

            </form>
        </div>

    </div>

</div>

<?php include('../stockage/footer.php'); ?>