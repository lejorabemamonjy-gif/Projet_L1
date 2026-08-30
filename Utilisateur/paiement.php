<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur_id = 1; // à remplacer par $_SESSION['id_utilisateur']
    $montant_total = $_POST['montant'];
    $mode = $_POST['mode'];
    $pourcentage = $_POST['pourcentage'];

    // Calcul du montant payé
    if ($pourcentage == "50%") {
        $montant_paye = $montant_total * 0.5;
    } else {
        $montant_paye = $montant_total;
    }
    $statut = 'réussi'; // tu peux tester 'échoué'

    // Enregistrement en base
    $stmt = $pdo->prepare("INSERT INTO paiements (utilisateur_id, montant, mode_paiement, pourcentage, statut)
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$utilisateur_id, $montant_paye, $mode, $pourcentage, $statut]);

    echo "<h3>Paiement simulé avec succès !</h3>";
    echo "<p>Mode : $mode</p>";
    echo "<p>Pourcentage : $pourcentage</p>";
    echo "<p>Montant payé :
$montant_paye Ar</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> paiement</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        form { display: inline-block; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        button { margin-top: 15px; padding: 10px 20px; }
    </style>
</head>
<body>
    <h2> paiement</h2>
    <form method="POST">
        <label>Montant total :</label>
        <input type="number" name="montant" step="0.01" required>

        <label>Mode de paiement :</label>
        <select name="mode">
            <option value="mobile_money">Mobile Money</option>
            <option value="carte_bancaire">Carte Bancaire</option>
        </select>

        <label>Pourcentage :</label>
        <select name="pourcentage">
            <option value="50%">50%</option>
            <option value="100%">100%</option>
        </select>

        <button type="submit">Envoyer</button>
    </form>
</body>
</html