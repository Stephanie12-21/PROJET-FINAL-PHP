<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';
$db = new Database();

if(isset($_POST['action']) && $_POST['action'] == "view")
{
    $output = '';
    if(isset($_POST['motifentre']) && !empty($_POST['motifentre'])) {
        $data = $db->searchEntre($_POST['motifentre']);
    } else {
        $data = $db->readentre();
    }
    $number = 1;
    if($db->totalRowCountE() > 0)
    {
        $output .= '<table class="table table-striped table-sm table-bordered">
        <thead class="thead-dark">
            <tr class="text-center">
                <th class="text-center">Numéro</th>
                <th class="text-center">Motif</th>
                <th class="text-center">Montant</th>
                <th class="text-center">Nom de l\'église</th>
                <th class="text-center">Date</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($data as $row) {
            $eglise = $db->getUserById($row['ideglise']) ;
            $nom_eglise = $eglise['designeglise'];
        
            $montantentre = number_format($row['montantentre']) . ' Ar';
            $output .= '<tr class="text-center text-secondary">
                <td class="text-center">' . $number . '</td>
                <td class="text-center">' . $row['motifentre'] . '</td>
                <td class="text-center">' . $montantentre . '</td>
                <td class="text-center">' . $nom_eglise . '</td>
                <td class="text-center">' . $row['dateentre'] . '</td>
                <td class="text-center">
                    <a href="#" title="Modifier" class="text-primary editBtn" id="'.$row['identre'].'" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                    <a href="#" title="Supprimer" class="text-danger delBtn" id="'.$row['identre'].'"><i class="fas fa-trash-alt fa-lg"></i></a>
                </td>
            </tr>';
            $number++;
        }
        
        $output .='</tbody></table>';
        echo $output;
    }
    else
    {
        echo '<h3 class="text-center text-secondary mt-5">:(No any data present in the database!)</h3>';
    }
}


?>
