<?php include('../stockage/HeaderOption.php'); ?>

<!-- Lien vers le fichier CSS -->
<link rel="stylesheet" href="reset.css">

<main class="px-4">
    <div class="pro-container">
        
        <?php if( isset($_GET['verif']) ): ?>
            
            <!-- Interface Succès -->
            <h1 class="pro-title">Mise à jour terminée</h1>
            <div class="accent-line"></div>
            
            <p class="text-body">Toutes les données enregistrées ont été réinitialisées avec succès.</p>
            <p class="text-body">Il est maintenant recommandé de configurer vos lignes de transport.</p>
            
            <a href="ligne.php" class="btn-action">Paramétrer les lignes</a>

        <?php else: ?>

            <!-- Interface Confirmation -->
            <h1 class="pro-title">Réinitialisation</h1>
            <div class="accent-line"></div>
            
            <p class="text-body">Souhaitez-vous effacer l'intégralité des données de la base ?</p>
            
            <a href="traitement3.php" class="btn-action" onclick="return confirm('Attention : Cette action supprimera TOUTES les données. Continuer ?')">
                Lancer le Reset
            </a>

            <div class="remarque-box">
                <h2>Remarque Importante</h2>
                <p class="text-body" style="font-size: 0.9rem; margin-bottom: 0;">
                    Cette fonction <strong>efface définitivement</strong> les réservations clients, 
                    les itinéraires (ex: TANA/SAMBAVA), les véhicules et l'historique complet du système.
                </p>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php include('../stockage/footer.php'); ?>