<?php
session_start();

require_once 'db.php'; 
$db = new Database(); 

if(isset($_POST['dateStart']) && isset($_POST['dateEnd'])) {
    $dateStart = $_POST['dateStart'];
    $dateEnd = $_POST['dateEnd'];

    $query = "SELECT sortie.*, eglise.designeglise FROM sortie INNER JOIN eglise ON sortie.ideglise = eglise.ideglise WHERE sortie.datesortie BETWEEN :dateStart AND :dateEnd";

    $stmt = $db->getConnection()->prepare($query);
    $stmt->bindParam(':dateStart', $dateStart);
    $stmt->bindParam(':dateEnd', $dateEnd);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        echo '<table class="table table-striped table-sm table-bordered">';
        echo '<thead class="thead-dark">';
        echo '<tr class="text-center">';
        echo '<th class="text-center">Numéro</th>';
        echo '<th class="text-center">Motif</th>';
        echo '<th class="text-center">Montant</th>';
        echo '<th class="text-center">Nom de l\'église</th>';
        echo '<th class="text-center">Date</th>';
        echo '<th class="text-center">Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $number = 1;
        $total_amount = 0; 

        $filtered_data = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         
            $filtered_data[] = $row;

           
            $total_amount += $row['montantsortie'];

          
            $montantsortie = number_format($row['montantsortie']) . ' Ar';
            echo '<tr class="text-center text-secondary">';
            echo '<td class="text-center">' . $number . '</td>';
            echo '<td class="text-center">' . $row['motifsortie'] . '</td>';
            echo '<td class="text-center">' . $montantsortie . '</td>';
            echo '<td class="text-center">' . $row['designeglise'] . '</td>';
            echo '<td class="text-center">' . $row['datesortie'] . '</td>';
            echo '<td class="text-center">';
            echo '<a href="#" title="Modifier" class="text-primary editBtn" id="'.$row['idsortie'].'" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;';
            echo '<a href="#" title="Supprimer" class="text-danger delBtn" id="'.$row['idsortie'].'"><i class="fas fa-trash-alt fa-lg"></i></a>';
            echo '</td>';
            echo '</tr>';
            $number++;
        }

       
        echo '</tbody>';
        echo '</table>';

        $_SESSION['filtered_data'] = $filtered_data;

        $total_amount_formatted = number_format($total_amount); 
        $_SESSION['total_amount'] = $total_amount;
    } else {
        echo '<p class="text-center">Aucune entrée trouvée pour les dates spécifiées.</p>';
    }
} else {
    echo '<p class="text-center">Veuillez fournir les dates de début et de fin pour effectuer la recherche.</p>';
}
?>


