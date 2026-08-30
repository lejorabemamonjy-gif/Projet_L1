<?php include('../stockage/HeaderOption.php'); ?>
<?php $id = $_GET['id']; ?>

<link rel="stylesheet" href="depart.css">

<main class="main-wrapper">
    <div class="pro-header">
        <h1>Réglage des départs</h1>
        <div class="accent-line"></div>
    </div>

    <form action="traitement2.php?id=<?= $id ?>" method="POST">
        <div id="container">
            <div class="bloc">
                <h3>Véhicule de départ</h3>
                <div class="grid-inputs">
                    <select name="jour[]" required>
                        <option>Lundi</option>
                        <option>Mardi</option>
                        <option>Mercredi</option>
                        <option>Jeudi</option>
                        <option>Vendredi</option>
                        <option>Samedi</option>
                        <option>Dimanche</option>
                    </select>

                    <input type="time" name="heure[]" required>
                    <input type="text" name="numv[]" placeholder="Immatriculation" required>
                    <input type="number" min=19 max=21 name="place[]" placeholder="Nombre de places" required>
                    <input type="text" name="chauffeur[]" placeholder="Chauffeur" required>
                    <input type="text" name="copilote[]" placeholder="Copilote" required>
                </div>
            </div>
        </div>

        <div class="actions">
            <button type="button" class="btn-add" onclick="ajouterBloc()">+ Ajouter une voiture</button>
            <button type="submit" class="btn-submit">Enregistrer les départs</button>
        </div>
    </form>
</main>

<script>
function ajouterBloc() {
    let container = document.getElementById("container");
    let bloc = document.createElement("div");
    bloc.classList.add("bloc");

    bloc.innerHTML = `
        <h3>Véhicule de départ</h3>
        <div class="grid-inputs">
            <select name="jour[]" required>
                <option>Lundi</option><option>Mardi</option><option>Mercredi</option>
                <option>Jeudi</option><option>Vendredi</option><option>Samedi</option>
                <option>Dimanche</option>
            </select>
            <input type="time" name="heure[]" required>
            <input type="text" name="numv[]" placeholder="Immatriculation" required>
            <input type="number" name="place[]" placeholder="Nombre de places" required>
            <input type="text" name="chauffeur[]" placeholder="Chauffeur" required>
            <input type="text" name="copilote[]" placeholder="Copilote" required>
        </div>
    `;
    container.appendChild(bloc);
}
</script>

<?php include('../stockage/footer.php'); ?>