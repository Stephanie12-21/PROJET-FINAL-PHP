<?php

require_once 'db.php';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['idsortie']) && isset($_POST['motifsortie']) && isset($_POST['montantsortie']) && isset($_POST['ideglise'])) {
       
        $motifsortie = $_POST['motifsortie'];
        $montantsortie = $_POST['montantsortie'];
        $ideglise = $_POST['ideglise'];

        $result = $db->updateSortie($idsortie, $motifsortie, $montantsortie, $ideglise);

        if ($result) {
            echo "success";
        } else {
            echo "Une erreur s'est produite lors de la mise à jour de la sortie.";
        }
    } else {
        echo "Toutes les données requises n'ont pas été fournies.";
    }
} else {
    echo "La méthode de requête n'est pas autorisée.";
}
?>
