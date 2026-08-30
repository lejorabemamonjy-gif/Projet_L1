<?php
session_start();

include "../config.php";
/** @var PDO $pdo */
include "../stockage/HeaderOption.php";

if ($_SESSION['role'] !== 'admin') {
    die("Accès refusé");
}

$result = $pdo->query("SELECT * FROM utilisateur");
$users = $result->fetchAll();
?>

<!-- Lien vers le fichier CSS -->
<link rel="stylesheet" href="styleutilisateur.css">

<div class="p-6">
    <div class="title">
        <h1 class="blood-title">👥 Gestion des utilisateurs</h1>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                    <th>Suppression</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="user-name">
                            <?= htmlspecialchars($u['nom']) ?>
                        </td>

                        <td class="user-email">
                            <?= htmlspecialchars($u['email']) ?>
                        </td>

                        <td>
                            <span class="badge <?= ($u['role'] === 'admin') ? 'badge-admin' : 'badge-user' ?>">
                                <?= ucfirst($u['role']) ?>
                            </span>
                        </td>

                        <td>
                            <a href="changement_role.php?id=<?= $u['id_utilisateur'] ?>&role=client"
                                class="action-link link-client"> Client</a>

                            <a href="changement_role.php?id=<?= $u['id_utilisateur'] ?>&role=employe"
                                class="action-link link-employe">Employé</a>

                            <a href="changement_role.php?id=<?= $u['id_utilisateur'] ?>&role=admin"
                                class="action-link link-admin">Admin</a>
                        </td>

                        <td>
                            <a href="delete.php?id=<?= $u['id_utilisateur'] ?>" id="delete"
                                onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');"> SUPPRIMER</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "../stockage/footer.php"; ?>