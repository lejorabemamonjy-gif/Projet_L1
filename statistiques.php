<?php
require_once 'config.php'; // connexion à la base

$stmt = $pdo->query("
    SELECT YEAR(date_voyage) AS annee, COUNT(*) AS total_voyages
    FROM voyages
    GROUP BY YEAR(date_voyage)
    ORDER BY annee DESC
");

$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des voyages</title>
    <style>
        table { border-collapse: collapse; width: 50%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Statistiques des voyages par année</h2>
    <table>
        <tr><th>Année</th><th>Total des voyages</th></tr>
        <?php foreach ($stats as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['annee']) ?></td>
                <td><?= htmlspecialchars($row['total_voyages']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
