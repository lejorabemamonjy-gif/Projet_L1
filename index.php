<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur TBN</title>
    <link rel="stylesheet" href="Accueil_TBN.css">
</head>
<body>
    
    <img src="stockage/logo_ispm.jpg" alt="Logo ISPM">

    <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
        <span class="bg-clip-text text-black bg-gradient-to-r from-gray-900 to-gray-600">Bienvenue sur TBN</span>
    </h1>

    <p class="text-gray-600 mb-4">
        Là où vous pouvait réserver en toute facilitée
    </p>

    <div class="mb-10">
        <?php
            $heure = date("H");
            if ($heure < 18) {
                echo '<div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 text-yellow-700 border border-yellow-100 font-medium">
                        <span class="mr-2">🌞</span> Bonne journée
                      </div>';
            } else {
                echo '<div class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100 font-medium">
                        <span class="mr-2">🌙</span> Bonne soirée
                      </div>';
            }
        ?>
    </div>

    <a href="Utilisateur/index.php" class="group relative inline-flex items-center justify-center px-8 py-3 font-bold text-white transition-all duration-200 bg-blue-600 rounded-xl hover:bg-blue-700 shadow-xl shadow-blue-200">
        Aller à l'accueil
    </a> 
</body>
</html>

