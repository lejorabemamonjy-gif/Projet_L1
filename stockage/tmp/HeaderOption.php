<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur TBN</title>
    <link rel="stylesheet" href="/Projet_L1/stockage/header_footer.css">
</head>
<body>
<header>

    <a href="/Projet_L1/AccueilTBN.php" class="text-white text-xl font-bold">
        TBN
    </a>

    <?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    ?>

    <div class="centrer">
        <div class="space-x-4 flex items-center">
            <a href="/Projet_L1/Utilisateur/index.php">Accueil</a>
            <a href="/Projet_L1/contact.php">Contact</a>
            <a href="/Projet_L1/Utilisateur/mes_reservation.php">Mes réservations</a>
        </div>

        <?php if(!isset($_SESSION['role'])): ?>
            <?php else: ?>
        <div class="option">

            

            <?php if($_SESSION['role'] === 'admin'): ?>
                <a href="/Projet_L1/employés/reservation.php" class="text-white">Réservation</a>
                <a href="/Projet_L1/employés/ligne.php" class="text-white">Ligne</a>
                <a href="/Projet_L1/employés/reset.php" class="text-white">Réinitialiser</a>
                <a href="/Projet_L1/admin/parametre.php" class="text-yellow-400">Paramètres</a>
                <a href="/Projet_L1/dashboard.php" class="text-white">Dashboard</a>
            <?php endif; ?>
            <?php if($_SESSION['role'] === 'employe'): ?>
                <a href="/Projet_L1/employés/reservation.php" class="text-white">Réservation</a>
                <a href="/Projet_L1/employés/ligne.php" class="text-white">Ligne</a>
                <a href="/Projet_L1/employés/reset.php" class="text-white">Réinitialiser</a>
                <a href="/Projet_L1/admin/parametre.php" class="text-yellow-400">Paramètres</a>
                <a href="/Projet_L1/dashboard.php" class="text-white">Dashboard</a>
            
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    
   
    <!-- <a href="/Projet_L1/logout.php" class="bg-red-500 text-white px-3 py-1 rounded" id="logout">Se déconnecter</a> -->

        
    </div>
    
    <?php 
        if(!isset($_SESSION['role'])){
            echo('<a href="/Projet_L1/login.php" class="connect" id="login">Se connecter</a>');
            
        }else{
            echo('<a href="/Projet_L1/logout.php" class="bg-red-500 text-white px-3 py-1 rounded" id="logout">Se déconnecter</a>');
        }

        if(isset($_SESSION['role']) && $_SESSION['role'] == 'client'){
            echo("<style>.option{display: none;}</style>");
        }
    ?>


</header>