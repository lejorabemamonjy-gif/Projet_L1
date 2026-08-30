<?php include('../stockage/HeaderOption.php');  

        $conn = new mysqli('localhost', 'root', '', 'tbn');

        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

    ?>

<link rel="stylesheet" href="style_succes.css">

<main>
    <div class= "boite_texte">
         <h1 class="text-3xl font-bold text-gray-800">
        Paramétrage terminé 
        </h1>
    
        <p class="texte_succes">
            Les voitures et trajets ont été enregistrés avec succès.
        </p>

        <div  class="lien_retour">
            <a href="../employés/ligne.php" class="btn_retour"> Créer nouvelle ligne</a>
        </div>
    </div>
   
</main>
   
<footer>
    <?php include('../stockage/footer.php'); ?>
</footer>
