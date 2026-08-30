<?php
session_start();
include('../stockage/HeaderOption.php');

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: /Projet_L1/login.php?message=connexion_requise");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données.");
}

$id_user = intval($_SESSION['id_utilisateur']);

// Message après annulation
$msg = $_GET['msg'] ?? '';
?>

<link rel="stylesheet" href="mes_reservations.css">

<main class="res-page">

    <h2 class="res-title">
        Mes réservations
        <span class="res-title-bar"></span>
    </h2>

    <?php if ($msg === 'annulee'): ?>
        <div class="res-flash">
            Réservation annulée avec succès.
        </div>
    <?php endif; ?>


    <?php

    $stmt = $conn->prepare("
        SELECT 
            r.id_reservation,
            r.num_place,
            r.status,
            r.date_reservation,
            t.jour,
            t.heure,
            v.matricule,
            ro.nom_route,
            ro.prix
        FROM reservation r
        JOIN trajet t 
            ON r.id_trajet = t.id_trajet
        JOIN voiture v 
            ON t.id_voiture = v.id_voiture
        JOIN route ro 
            ON t.id_route = ro.id_route
        WHERE r.id_utilisateur = ?
        ORDER BY r.date_reservation DESC
    ");

    $stmt->bind_param("i", $id_user);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows === 0):
    ?>

        <div class="res-empty">

            <p><span>❌</span>Aucune réservation pour l'instant.<span>❌</span></p>

            <a href="/Projet_L1/Utilisateur/index.php"
               class="res-btn-back">
                Voir les routes disponibles
            </a>

        </div>

    <?php
    else:

        while ($row = $result->fetch_assoc()):

            $isActive = ($row['status'] === 'active');

    ?>

        <div class="res-card <?= $isActive
            ? 'res-card--active'
            : 'res-card--annulee' ?>">

            <!-- ROUTE -->
            <div class="res-card__route">
                <h3> <?= htmlspecialchars($row['nom_route']) ?></h3>
            </div>


            <div class="res-card__grid">

                <table class="tab-res">
                    <tr id="head">
                        <th>
                             <span class="res-info__label">Jour</span>
                        </th>

                        <th>
                            <span class="res-info__label">Heure</span>
                        </th>

                        <th>
                            <span class="res-info__label">Voiture</span>
 
                        </th>

                        <th>
                            <span class="res-info__label">Place</span>
                        </th>

                        <th>
                            <span class="res-info__label">Prix </span>
                        </th>

                        <th>
                             <span class="res-info__label">
                                Status
                            </span>
                        </th>
                    </tr>
                    <tr id="cellule">
                        <!-- JOUR -->
                        <td>
                            <span class="res-info__value">
                            <?= htmlspecialchars($row['jour']) ?>
                            </span>
                        </td>

                         <!-- HEURE -->
                        <td>
                            <span class="res-info__value">
                                <?= htmlspecialchars(
                                substr($row['heure'], 0, 5)
                                ) ?>
                            </span>
                        </td>

                        <!-- VOITURE -->
                        <td>
                            <span class="res-info__value">
                                <?= htmlspecialchars($row['matricule']) ?>
                            </span>
                        </td>

                        <!-- PLACE -->
                        <td>
                             <span class="res-info__value">

                                <?php
                                    /*
                                     * La base contient les vrais numéros :
                                     * 3, 4, 5...
                                    *
                                    * L'utilisateur voit :
                                   * 1, 2, 3...
                                    *
                                    * On retire donc 2.
                                    */
                                    $place_affichee = intval($row['num_place']) - 2;
                                ?>

                                <?= $place_affichee ?>

                            </span>
                        </td>

                        <!-- PRIX -->
                        <td>
                            <span class="res-info__value">
                                <?= number_format(
                                 $row['prix'],
                                0,
                                ',',
                                ' '
                                ) ?> Ar
                            </span>
                        </td>

                        <!-- STATUS -->
                        <td>
                            <span class="res-info__value">

                                <?php if ($isActive): ?>

                            <span class="status-active">
                                Active
                            </span>

                            <?php else: ?>

                                <span class="status-cancelled">
                                    Annulée
                                </span>

                            <?php endif; ?>

                    </span>

                        </td>
                    </tr>
                </table>
            </div>
            <!-- ACTION -->
            <?php if ($isActive): ?>

                <div class="res-card__actions">

                    <a
                        href="annuler.php?id=<?= intval($row['id_reservation']) ?>"
                        class="res-btn-cancel"
                        onclick="return confirm('Voulez-vous vraiment annuler cette réservation ?');"
                    >
                        Annuler la réservation
                    </a>

                </div>

            <?php endif; ?>


        </div>

    <?php

        endwhile;

    endif;

    ?>

</main>

<?php include('../stockage/footer.php'); ?>