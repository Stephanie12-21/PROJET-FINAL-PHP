<?php
require_once 'db.php';
$db = new Database();

if(isset($_POST['identre'])) 
    {
        $identre = $_POST['identre'];

        $entryDetails = $db->getEntryDetails($identre);
        $montantEntree = $entryDetails['montantentre'];
        $ideglise = $entryDetails['ideglise'];

        $egliseDetails = $db->getUserById($ideglise);
        $soldeActuel = $egliseDetails['soldeeglise'];
        $nouveauSolde = $soldeActuel - $montantEntree;
        $db->updateSoldeEglise($ideglise, $nouveauSolde);

        $db->deleteEntrance($identre);

        echo json_encode(array('success' => true));
    } 
    else 
    {
        echo json_encode(array('success' => false, 'message' => 'Identifiant de l\'entrée non défini.'));
    }
?>
