<?php
session_start();
include "config.php";

/** @var PDO $pdo */

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom']    ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email  = trim($_POST['email']  ?? '');
    $mdp    = $_POST['mdp']         ?? '';
    $mdp2   = $_POST['mdp2']        ?? '';

    if ($mdp !== $mdp2) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email existe déjà
        $check = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = ?");
        $check->execute([$email]);

        if ($check->fetch()) {
            $error = "Cette adresse e-mail est déjà utilisée.";
        } else {
            $hash = md5($mdp);
            $stmt = $pdo->prepare("
                INSERT INTO utilisateur (nom, prenom, email, password, role)
                VALUES (?, ?, ?, ?, 'client')
            ");
            $stmt->execute([$nom, $prenom, $email, $hash]);

            header("Location: login.php?inscrit=1");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — TBN</title>
    <link rel="stylesheet" href="style_auth.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">

        <div class="auth-card__header">
            <span class="auth-card__logo">TBN</span>
            <span class="auth-card__subtitle">Créer un compte</span>
        </div>

        <form class="auth-card__body" method="POST" action="">

            <div class="auth-field">
                <label class="auth-label" for="nom">Nom</label>
                <input class="auth-input"
                       type="text"
                       id="nom"
                       name="nom"
                       placeholder="Rakoto"
                       value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                       required>
            </div>

            <div class="auth-field">
                <label class="auth-label" for="prenom">Prénom</label>
                <input class="auth-input"
                       type="text"
                       id="prenom"
                       name="prenom"
                       placeholder="Jean"
                       value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
                       required>
            </div>

            <div class="auth-field">
                <label class="auth-label" for="email">Adresse e-mail</label>
                <input class="auth-input"
                       type="email"
                       id="email"
                       name="email"
                       placeholder="votre@email.com"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       required>
            </div>

            <div class="auth-field">
                <label class="auth-label" for="mdp">Mot de passe</label>
                <input class="auth-input"
                       type="password"
                       id="mdp"
                       name="mdp"
                       placeholder="••••••••"
                       required>
            </div>

            <div class="auth-field">
                <label class="auth-label" for="mdp2">Confirmer le mot de passe</label>
                <input class="auth-input"
                       type="password"
                       id="mdp2"
                       name="mdp2"
                       placeholder="••••••••"
                       required>
            </div>

            <button type="submit" class="auth-btn">
                ✅ Créer mon compte
            </button>

            <?php if ($error): ?>
                <p class="auth-error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

        </form>

        <div class="auth-card__footer">
            <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
        </div>

    </div>
</div>

</body>
</html>
