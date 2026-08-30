<?php 

session_start();
include('../stockage/HeaderOption.php');
?>
<section>
<?php 


$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die('Erreur de connexion !!');
}

// récupérer routes
$routes = $conn->query("SELECT * FROM route");
?>
<head>
    <link rel="stylesheet" href="Style_index.css">
</head>

<div class="routes-container">
    <h1 class="page-title">Routes disponibles</h1>
    <div class="contenaire">
    
<?php if ($routes->num_rows > 0): ?>

    <?php while ($row = $routes->fetch_assoc()): ?>

        <?php
        $id = $row['id_route'];

        // nombre de trajets
        $count = $conn->query("
            SELECT COUNT(*) as total 
            FROM trajet 
            WHERE id_route = $id
        ")->fetch_assoc()['total'];

        // dispo
        $dispo = $conn->query("
            SELECT * FROM trajet 
            WHERE id_route = $id 
            AND places_disponibles > 0
        ");

        $isDisponible = ($dispo->num_rows > 0);
        $status = $isDisponible ? "Disponible" : "Complet";
        $statusClass = $isDisponible ? "status-available" : "status-full";
        $btnClass = $isDisponible ? "available" : "disabled";

        // lien intelligent
        $link = isset($_SESSION['id_utilisateur'])
            ? "trajet.php?id=$id&jour=Lundi"
            : "/Projet_L1/login.php?message=connexion_requise&redirect=Utilisateur/trajet.php?id=$id&jour=Lundi";

        // texte bouton
        $btnText = isset($_SESSION['id_utilisateur']) 
            ? "Réserver" 
            : "Se connecter";
        ?>

        <!-- CARTE -->

            <div class="card">
                 <!-- IMAGE -->
                <div class="img">
                    <img src="/Projet_L1/graphic-node-yPSbirjJWzs-unsplash.jpg" class="image-card">
                </div>
                
                <!-- NOM -->
                <div class="contenuText">
                    <h3><?= $row['nom_route'] ?></h3>

                    <!-- PRIX -->
                    <p class="route-price"><?= $row['prix'] ?> Ar</p>

                    <!-- TRAJETS -->
                    <p class="route-count"><?= $count ?> trajets disponibles</p>

                    <!-- STATUT -->
                    <p class="route-status <?= $statusClass ?>">● <?= $status ?></p>

                    <!-- BOUTONS -->
                    <div class="btn-group">

                        <!-- voir trajets -->
                        <a href="trajet.php?id=<?= $id ?>">
                            <button class="btn-view">Voir trajets</button>
                        </a>

                        <!-- réserver -->
                        <a href="<?= $link ?>">
                            <button class="btn-action <?= $btnClass ?>" <?= !$isDisponible ? 'disabled' : '' ?>>
                                <?= $btnText ?>
                            </button>
                        </a>

                    </div>
                </div>
                

            </div>

    <?php endwhile; ?>

<?php else: ?>
    <p>Aucune route disponible</p>
<?php endif; ?>
</div>
</div>
</section>

