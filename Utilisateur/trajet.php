<?php
session_start();
include('../stockage/HeaderOption.php');

$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur de connexion");
}

$id_route = isset($_GET['id']) ? intval($_GET['id']) : 0;
$jour     = $_GET['jour'] ?? 'Lundi';

if ($id_route === 0) {
    die("Route invalide");
}

$jours_semaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
?>
<head>
    <link rel="stylesheet" href="styletrajet.css">
</head>
<div class="trajet-wrapper">

    <h2 class="pro-title">
        <span class="sticker"></span> Jour sélectionné : <?= htmlspecialchars($jour) ?>
    </h2>

    <div class="day-selector">
        <?php foreach ($jours_semaine as $j): ?>
            <a href="?id=<?= $id_route ?>&jour=<?= $j ?>"
               class="day-link <?= ($jour === $j) ? 'active' : '' ?>">
                <?= $j ?>
            </a>
        <?php endforeach; ?>
    </div>

    <h3 class="pro-title" style="font-size: 1.8rem; text-align: left; margin-bottom: 20px;">
        <span class="sticker"></span> Trajets disponibles
    </h3>

    <?php
    $stmt = $conn->prepare("
        SELECT t.*, v.matricule, v.chauffeur
        FROM trajet t
        JOIN voiture v ON t.id_voiture = v.id_voiture
        WHERE t.id_route = ? AND t.jour = ?
        ORDER BY t.heure ASC
    ");
    $stmt->bind_param("is", $id_route, $jour);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<p style='text-align:center;color:#64748b;font-weight:bold;margin:40px 0;'>
              Aucun trajet disponible ce jour-là.</p>";
    }

    while ($row = $result->fetch_assoc()):
        $redirect  = "Utilisateur/trajet.php?id={$id_route}&jour={$jour}";

        if (isset($_SESSION['id_utilisateur'])) {
            $link      = "place.php?id_trajet=" . intval($row['id_trajet']);
            $text      = "Choisir ce trajet";
            $btn_class = "btn-connected";
        } else {
            $link      = "/Projet_L1/login.php?message=connexion_requise&redirect=" . urlencode($redirect);
            $text      = "Se connecter pour réserver";
            $btn_class = "btn-login";
        }
    ?>
    <div class="trajet-card">
        <div class="trajet-info">
            <div class="info-item">
                <span class="sticker"></span> Heure : <?= htmlspecialchars(substr($row['heure'], 0, 5)) ?>
            </div>
            <div class="info-item">
                <span class="sticker"></span> Voiture : <?= htmlspecialchars($row['matricule']) ?>
            </div>
            <div class="info-item">
                <span class="sticker"></span> Chauffeur : <?= htmlspecialchars($row['chauffeur']) ?>
            </div>
            <div class="info-item">
                <span class="sticker"></span> Places dispo : <?= intval($row['places_disponibles']-2) ?>
            </div>
        </div>
        <a href="<?= $link ?>">
            <button class="btn-reserve <?= $btn_class ?>"
                    <?= ($row['places_disponibles'] <= 0) ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '' ?>>
                <?= ($row['places_disponibles'] <= 0) ? 'Complet' : $text ?>
            </button>
        </a>
    </div>
    <?php endwhile; ?>

</div>

<?php include('../stockage/footer.php'); ?>
