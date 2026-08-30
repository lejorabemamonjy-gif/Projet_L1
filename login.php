<?php
session_start();
include "config.php";

$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur de connexion");
}

$error = "";

// TRAITEMENT LOGIN
if (isset($_POST['email'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $res = $conn->query("
        SELECT * FROM utilisateur 
        WHERE email='$email' AND password='$password'
    ");

    if ($res && $res->num_rows === 1) {

        $user = $res->fetch_assoc();

        // SESSION PROPRE
        $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['role'] = $user['role'];

        // REDIRECTION APRÈS LOGIN
        $redirect = "/Projet_L1/Utilisateur/index.php"; // par défaut

        if (isset($_GET['redirect']) && $_GET['redirect'] != "") {
            $redirect = $_GET['redirect'];
        }

        // redirection selon rôle SI PAS DE REDIRECT
        if (!isset($_GET['redirect']) || $_GET['redirect'] == "") {

            if ($user['role'] === 'admin') {
                $redirect = "/Projet_L1/employés/ligne.php";

            } elseif ($user['role'] === 'employe') {
                $redirect = "/Projet_L1/employés/ligne.php";

            } else {
                $redirect = "/Projet_L1/Utilisateur/index.php";
            }
        }

        header("Location: $redirect");
        exit();

    } else {
        $error = "❌ Email ou mot de passe incorrect";
    }
}
?>

<?php include "stockage/HeaderOption.php"; ?>

<!-- LIAISON VERS LE CSS DU LOGIN -->
<link rel="stylesheet" href="style_login.css">

<!-- FORMULAIRE UNIQUE AVEC CLASSE DE CONTRÔLE -->
<div class="login-page-container">

    <h2>Connexion</h2>

    <form method="POST">
        <label for="Email">Email</label>
        <input type="email" name="email" required><br>

        <label for="Password">Password</label>
        <input type="password" name="password" required>
        
        
        <button type="submit">
            Se connecter
        </button>
        <p>ou</p>
        <p>pas de compte utilisateur ?<a href="/Projet_L1/register.php" class="inscrip">register</a>
        </p>
    </form>

    <!-- MESSAGE ERREUR -->
    <?php if ($error != ""): ?>
        <p class="login-error-text">
            <?= $error ?>
        </p>
    <?php endif; ?>

</div>

<?php include "stockage/footer.php"; ?>