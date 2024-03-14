<?php
require_once 'db.php';
$db = new Database();

if(isset($_POST['action']) && $_POST['action'] == "view")
{
    $output = '';
    $data = $db->readeglise();
    $number = 1;
    if($db->totalRowCount() > 0)
    {
        $output .= '<table class="table table-striped table-sm table-bordered">
        <thead class="thead-dark">
            <tr class="text-center">
                <th class="text-center">Numéro</th>
                <th class="text-center">Nom de l\'église</th>
                <th class="text-center">Solde de l\'église</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($data as $row) {
            $solde = number_format($row['soldeeglise']) . ' Ar';
            $output .= '<tr class="text-center text-secondary">
            <td class="text-center">' . $number . '</td>
            <td class="text-center">' . $row['designeglise'] . '</td>
            <td class="text-center">' . $solde . '</td>
            <td class="text-center">                
                <a href="#" title="Modifier" class="text-primary editBtn" id="'.$row['ideglise'].'" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;

                <a href="#" title="Supprimer" class="text-danger delBtn" id="'.$row['ideglise'].'"><i class="fas fa-trash-alt fa-lg"></i></a>
            </td></tr>';
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
 
if(isset($_POST['action']) && $_POST['action'] == "inserteglise")
{
    $designeglise = $_POST['designeglise'];

    if($db->checkEgliseExists($designeglise)) {
        
        echo json_encode(array('error' => 'Le nom de l\'église existe déjà dans la base de données.'));
    } else {
       
        $db->inserteglise($designeglise);
       
        echo json_encode(array('success' => 'L\'ajout de l\'église a été un succès.'));
    }
}



 if(isset($_POST['edit_id']))
{
    $ideglise = $_POST['edit_id'];

    $row = $db->getUserById($ideglise);
    if ($row) {
        echo json_encode($row);
    } else {
        echo json_encode(array('error' => 'Église non trouvée'));
    }
}

if(isset($_POST['action']) && $_POST['action'] == "updateeglise")
{
   $ideglise = $_POST['ideglise'] ;
   $designeglise = $_POST['designeglise'];

   $db->updateEglise($ideglise, $designeglise);
}


if(isset($_POST['del_ideglise']))
{
    $ideglise = $_POST['del_ideglise'];

    $db->deleteEglise($ideglise);
}


?>
