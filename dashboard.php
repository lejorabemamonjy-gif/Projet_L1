<?php
include('stockage/HeaderOption.php');

//connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'tbn');
//verif
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données.");
}
$mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mais', 'Juin', 'Juillet', 
'Août', 'Septembre', 'Ocobre', 'novembre', 'Décembre'];


//NOMBRE DE RESERVATION
$sql = "SELECT COUNT(*) AS total, SUM(status = 'active') AS reussies, SUM(status = 'annulee') AS annulee FROM reservation_stat";

$resultat = $conn->query($sql);
$total = 0;
$reussies = 0;
$annulee = 0;

while($row = $resultat->fetch_assoc()){
    $total += $row['total'];
    $reussies += $row['reussies'];
    $annulee += $row['annulee'];
}

// //NOMBRE D'ANNULATION
// $sql = "SELECT YEAR(date_reservation) AS annee, 
//                 MONTH(date_reservation) AS mois, 
//                 COUNT(*) AS nombre_annulation 
//         FROM reservation_stat 

//         WHERE status = 'annulee'
        
//         GROUP BY YEAR(date_reservation),
//                 MONTH(date_reservation)
//         ORDER BY annee, mois";

// $nbr_annulation = 0;
// $result_annulation = $conn->query($sql);
// while($row = $result_annulation->fetch_assoc()){
//     $nbr_annulation += $row['nombre_annulation'];
// }

// ?>

<head>
    <link rel="stylesheet" href="style_dashbord.css">
</head>

<div class="divStat">
    <h2><img src='/projet_l1/asset/icon/dashboard.png' alt='icon check' id='icon_dash'> DASHBOARD</h2>
    <div class="divGauche">
        <div class="reservation">
            <img src='/projet_l1/asset/icon/calendrier.png' alt='icon check' style='background: #338dff;'>
            <p class="val" style='color: #338dff;'><?php echo number_format($total, 0, ',', ' ')?></p>

            <p class="label">Réservations</p>
        </div>

        <div class="reservation">
            <img src='/projet_l1/asset/icon/check.png' alt='icon check' style='background: #33ff55;'>
            <p class="val"><?php echo number_format($reussies, 0, ',', ' ')?></p>

            <p class="label">Confirmées</p>
        </div>

        <div class="annulation">
            <img src='/projet_l1/asset/icon/croix.png' alt='icon check' style='background: #e12d4f;'>
            <p class="val"><?php echo number_format($annulee, 0, ',', ' ')?></p>
            <p class="label">Annulées</p>
        </div>
    </div>

    <div class="divNav">
        <a href="" id='grap'>Réservations/mois</a>
        <a href="">Jours de départ</a>
        <a href="">Jours de départ</a>
    </div>
    
    <h4 id='titre1'>Réservations par mois</h4>
    <div class="graphique">
        
        <canvas id="mongraphe"></canvas>
        <script src="js/chart.umd.js"></script>
        <script src="js/chartjs-plugin-datalabels.js"></script>

        <script>
            const graphe = document.getElementById("mongraphe");

            new Chart(graphe, {
                    type: 'bar',
                    
                    data: {
                        // labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'],

                        <?php 
                            $sql = "SELECT YEAR(date_reservation) AS annee, 
                                    MONTH(date_reservation) AS mois, 
                                    COUNT(*) AS nombre_reservation 
                            FROM reservation_stat 

                            WHERE status = 'active'

                            GROUP BY YEAR(date_reservation),
                                    MONTH(date_reservation)
                            ORDER BY annee, mois";

                            $resultat = $conn->query($sql);  

                            $labels = [];
                            while($row = $resultat->fetch_assoc()){
                                $index = (int) $row['mois'] - 1;
                                $labels[] = $mois[$index];
                            }
                            echo "labels: " . json_encode($labels) . ",";
                        ?>

                        datasets: [{
                            label: 'Nombre de réservations',
                            // data: [12, 19, 8, 25, 40, 20],

                            <?php 
                                $sql = "SELECT YEAR(date_reservation) AS annee, 
                                        MONTH(date_reservation) AS mois, 
                                        COUNT(*) AS nombre_reservation 
                                FROM reservation_stat 

                                WHERE status = 'active'

                                GROUP BY YEAR(date_reservation),
                                        MONTH(date_reservation)
                                ORDER BY annee, mois";

                                $resultat = $conn->query($sql); 

                                echo("data: [");
                                if($resultat->num_rows > 0){
                                    while($row = $resultat->fetch_assoc()){
                                        echo $row['nombre_reservation'].', ';
                                    }
                                }
                                else{
                                    echo(0);
                                }
                                
                                echo('],');
                            ?>

                            barPercentage: 0.5
                            // barThickness: 40

                        },
                    
                        {
                            label: "Nombre d'annulations",
                            
                            <?php 
                                $sql = "SELECT YEAR(date_reservation) AS annee, 
                                        MONTH(date_reservation) AS mois, 
                                        COUNT(*) AS nombre_annulation
                                FROM reservation_stat 

                                WHERE status = 'annulee'

                                GROUP BY YEAR(date_reservation),
                                        MONTH(date_reservation)
                                ORDER BY annee, mois";

                                $resultat = $conn->query($sql); 

                                echo("data: [");
                                if($resultat->num_rows > 0){
                                    while($row = $resultat->fetch_assoc()){
                                        echo $row['nombre_annulation'].', ';
                                    }
                                }
                                else{
                                    echo(0);
                                }
                                
                                echo('],');
                            ?>
                            barThickness: 40
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

        </script>
    </div>
    
    <h4 id="titre2">Répartition des réservations</h4>
    <div class="graphique2">
        
        <canvas id='circulaire'></canvas>
        <script>
            const circulaire = document.querySelector("#circulaire");


            new Chart(circulaire, {
                type: 'pie',

                data: {

                    labels: ['Réservations confirmées', 'Réservations annulées'],

                    datasets: [{
                        label: 'Valeurs',
                        data: [<?php echo $reussies.','.$annulee?>],

                        backgroundColor: ['#33ff55', '#e45f77ff'],

                        borderWidth: 0
                    }],


                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            position: 'bottom'
                        },

                        datalabels: {
                            formatter: (value, context) => {
                                const data = context.chart.data.datasets[0].data;

                                const total = data.reduce((a, b) => a + b, 0);

                                const pourcentage = (value / total) * 100;

                                return pourcentage.toFixed(1) + '%';
                            },

                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 14
                            }
                        }
                    }
                },

                plugins: [ChartDataLabels]
            });
        </script>
    </div>
</div>

<!-- test -->
<?php 
    // $sql = "SELECT YEAR(date_reservation) AS annee, 
    //         MONTH(date_reservation) AS mois, 
    //         COUNT(*) AS nombre_reservation 
    // FROM reservation_stat 

    // WHERE status = 'active'

    // GROUP BY YEAR(date_reservation),
    //         MONTH(date_reservation)
    // ORDER BY annee, mois";

    // $resultat = $conn->query($sql);  

    

    // echo("labels: ['");
    // while($row = $resultat->fetch_assoc()){
    //     $index = (int) $row['mois'] - 1;
    //     echo $mois[$index];

    //     echo("', ");
    // }
    // echo("],");
?>

<?php 
    // $sql = "SELECT YEAR(date_reservation) AS annee, 
    //         MONTH(date_reservation) AS mois, 
    //         COUNT(*) AS nombre_reservation 
    // FROM reservation_stat 

    // WHERE status = 'active'

    // GROUP BY YEAR(date_reservation),
    //         MONTH(date_reservation)
    // ORDER BY annee, mois";

    // $resultat = $conn->query($sql); 

    // echo("data: [");
    // while($row = $resultat->fetch_assoc()){
    //     echo $row['nombre_reservation'].', ';
    // }
    // echo(']');


    // $sql = "SELECT YEAR(date_reservation) AS annee, 
    //         MONTH(date_reservation) AS mois, 
    //         COUNT(*) AS nombre_annulation
    // FROM reservation_stat 

    // WHERE status = 'annulee'

    // GROUP BY YEAR(date_reservation),
    //         MONTH(date_reservation)
    // ORDER BY annee, mois";

    // $resultat = $conn->query($sql); 

    // echo("data: [");
    // if($resultat->num_rows > 0){
    //     while($row = $resultat->fetch_assoc()){
    //         echo $row['nombre_annulation'].', ';
    //     }
    // }
    // else{
    //     echo(0);
    // }
    
    // echo('],');
?>

<!-- script -->


<script src='dashboard.js'></script>