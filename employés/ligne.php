<?php include('../stockage/HeaderOption.php'); ?>

<!-- APPEL DU FICHIER CSS -->
<link rel="stylesheet" href="styleligne.css">

<main class="main-container">
    
    <div class="page-header">
        <h1>Création de ligne</h1>
        <div class="title-bar"></div>
    </div>

    <div class="form-card">
        
        <div class="form-banner">
            <p>Informations de trajet</p>
        </div>

        <form action="traitement1.php" method="POST" class="form-body">
            
            <!-- Sélection Ligne -->
            <div class="form-group">
                <label for="ligne" class="label-text">Ligne de transport</label>
                <select id="ligne" name="ligne" class="input-field select-custom">
                    <option value="TANA-->SAMBAVA">TANA / SAMBAVA</option>
                    <option value="TANA-->TOAMASINA">TANA / TOAMASINA</option>
                    <option value="TANA-->MAHAJANGA">TANA / MAHAJANGA</option>
                </select>
            </div>

            <!-- Champ Prix -->
            <div class="form-group">
                <label for="prix" class="label-text">Prix du ticket (Ar)</label>
                <input type="text" id="prix" name="prix" placeholder="Ex: 50 000" class="input-field">
            </div>

            <!-- Bouton Suivant -->
            <button type="submit" class="btn-submit">
                <span>Suivant</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>

        </form>
    </div>
</main>

<?php include('../stockage/footer.php'); ?>