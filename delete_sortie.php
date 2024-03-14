<?php
require_once 'db.php';
$db = new Database();

if(isset($_POST['idsortie'])) 
    {
        $idsortie = $_POST['idsortie'];

        $sortieDetails = $db->getSortieDetails($idsortie);
        $montantSortie = $sortieDetails['montantsortie'];
        $ideglise = $sortieDetails['ideglise'];

        $egliseDetails = $db->getUserById($ideglise);
        $soldeActuel = $egliseDetails['soldeeglise'];
        $nouveauSolde2 = $soldeActuel + $montantSortie;
        $db->updateSoldeEglise2($ideglise, $nouveauSolde2);

        $db->deleteSortie($idsortie);

        echo json_encode(array('success' => true));
    } 
    else 
    {
        echo json_encode(array('success' => false, 'message' => 'Identifiant de l\'entrée non défini.'));
    }

    
?>


