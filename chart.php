<?php
include 'db.php'; 

$database = new Database();

$eglises = $database->readeglise();

$eglises_json = json_encode($eglises);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Graphs</title>
    
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Inclure Chart.js -->
    <script src="chart.js"></script>
</head>
<body>
    <br /><br />
    <div class="container" style="width:900px;">
        <h2 class="text-center">La repésentation graphique des données dans la table "eglise"</h2>
        <h3 class="text-center"><u>Voici l'histogramme représentatif des églises suivant leur solde total</u></h3>   
        <br /><br />
        <canvas id="myChart"></canvas> 
    </div>

    <div class="container">
        <button class="btn btn-outline-danger btn-sm"><a href="eglise.php" style="text-decoration: none; color: red;">Retour</a></button>
    </div>

    <script>
        var eglises = <?php echo $eglises_json; ?>;

        var nomsEglises = eglises.map(function(eglise) {
            return eglise.designeglise;
        });
        var soldesEglises = eglises.map(function(eglise) {
            return eglise.soldeeglise;
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: nomsEglises,
                datasets: [{
                    label: 'Solde des églises (Ar)',
                    data: soldesEglises,
                    backgroundColor: soldesEglises.map(function(solde) {
                        if (solde <= 10000) {
                            return '#F08080'; // Rouge
                        } else if (solde <= 50000) {
                            return '#FFFF62'; // Jaune
                        } else {
                            return 'rgb(144,238,144)'; // Vert
                        }
                    }),
                    borderColor: soldesEglises.map(function(solde) {
                        if (solde <= 10000) {
                            return '#F08080';
                        } else if (solde <= 50000) {
                            return '#FFFF62';
                        } else {
                            return 'rgba(75, 192, 192, 1)';
                        }
                    }),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
