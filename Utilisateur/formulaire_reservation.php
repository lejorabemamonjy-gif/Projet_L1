<?php
session_start();
include('../stockage/HeaderOption.php');

// Vérif connexion
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: /Projet_L1/login.php?message=connexion_requise");
    exit();
}


$conn = new mysqli('localhost', 'root', '', 'tbn');

if ($conn->connect_error) {
    die("Erreur connexion");
}

// Récupérer les places choisies et le trajet depuis POST
$id_trajet = isset($_POST['id_trajet']) ? intval($_POST['id_trajet']) : 0;
$places    = $_POST['places'] ?? [];

if ($id_trajet === 0 || count($places) === 0) {
    die("❌ Aucune place sélectionnée ou trajet invalide.");
}

// Récupérer les infos du trajet pour les afficher
$stmt = $conn->prepare("
    SELECT t.jour, t.heure, v.matricule, ro.nom_route, ro.prix
    FROM trajet t
    JOIN voiture v  ON t.id_voiture = v.id_voiture
    JOIN route ro   ON t.id_route   = ro.id_route
    WHERE t.id_trajet = ?
");
$stmt->bind_param("i", $id_trajet);
$stmt->execute();
$trajet = $stmt->get_result()->fetch_assoc();

if (!$trajet) {
    die("❌ Trajet introuvable.");
}
?>

<link rel="stylesheet" href="styleformulaire_reservation.css">

<h2>Informations du passager</h2>
<section class="formulaire">
    <form action="traitement.php" method="POST" id="formulaire">

        <!-- Passer les données cachées vers traitement.php -->
        <input type="hidden" name="id_trajet" value="<?= $id_trajet ?>">
            <?php foreach ($places as $p): ?>
        <input type="hidden" name="places[]" value="<?= intval($p) ?>">
            <?php endforeach; ?>

        <input type="text"   name="nom"              placeholder="Nom"                  required><br>
        <input type="text"   name="prenom"           placeholder="Prénom"               required><br>
        <input type="text"   name="CIN"              placeholder="Numéro CIN"           required maxlength="12"><br>
        <input type="tel"    name="numero_telephone" placeholder="Téléphone (10 chiffres)" required maxlength="10" pattern="[0-9]{10}"><br>
        <input type="tel"    name="contact_urgence"  placeholder="Contact urgence (10 chiffres)" required maxlength="10" pattern="[0-9]{10}">
    
   
        <div id="Avance" required>
            <p id="cache">Payement Avance<p>
        </div>

        <div class="payement">
            <style>
                .contenaireChamp{
                    /* background: red; */
                    display: grid;
                    grid-template-columns: 0.7fr 1.3fr;
                    gap: 10px;
                    /* grid-template-rows: 50px; */

                    align-items: center;

                    padding: 10px 20px;
                }

                .payment input, select{
                    margin-bottom: 0;
                }

                .btn_bottom{
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 10px;
                    padding: 20px;
                }

            </style>
            <h2 style="margin-top: 0px; color: white;">PAIEMENT</h2>
            <div class="contenaireChamp">
                <label for="operateur">Opérateur :</label>

                <select id="operateur" name="operateur">
                    <option value="MVOLA">MVOLA</option>
                    <option value="ORANGE MONEY">ORANGE MONEY</option>
                    <option value="AIRTEL MONEY">AIRTEL MONEY</option>
                </select>
            </div>
            


            <div class="contenaireChamp">
                <label for="telephone">Numéro de téléphone :</label>

                <input 
                    type="texte"
                    id="telephone" 
                    name="telephone"
                    pattern="0[0-9]{9}"
                    placeholder="Veullez entrer votre numero selon l'operateur"
                >
            </div>
            


            <p id="or">ou</p>


            <div class="contenaireChamp">
                <label for="carte_credit">Numero carte bancaire</label>

                <input 
                    type="number"
                    id="carte_credit"
                    name="cate_credit"
                    placeholder="Veullez entrer votre carte bancaire"
                >
            </div>
            



            <div class="contenaireChamp">
                <label for="montant">Montant (20000Ar minimum)</label>

                <input 
                    type="number" 
                    id="montant" 
                    min="20000"
                    name="montant"
                    placeholder="Veullez entrer le montant requis"
                    required
                >
            </div>
            

            <div class="btn_bottom">
                <div id="paiement_envoie" >
                    <p id="texte" style="display: block; grid-column: 1/2;">Payer</p>
                </div>
                <h3 id="envoie_reussi"></h3>
                <div id="btn_retour">
                    <p style="display: block; grid-column: 2/3;">retour</p>
                </div>
            </div>
            
       
        </div>

        <button type="submit" id="submit">Confirmer la réservation</button>

    </form>
</section>

    <!--TRANSMISSION DES DONNEES PAYEMENT A LA BASE-->
<?php
    include('../config.php');

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $operateur= trim($_POST['operateur'] ?? '');
        $telephone= trim($_POST['telephone'] ?? '');
        $carte_credit= trim($_POST['carte_credit'] ?? '');
        $montant= trim($_POST['montant'] ?? '');

        $insert= $pdo->prepare("
                INSERT INTO formulaire (operateur, telephone, carte_credit, montant)
                VALUES (?, ?, ?, ?)
            ");
        
        $insert->execute([$operateur, $telephone, $carte_credit, $montant]);

    }
?>

<script src="formulaire_reservation.js"></script>

<?php include('../stockage/footer.php'); ?>
