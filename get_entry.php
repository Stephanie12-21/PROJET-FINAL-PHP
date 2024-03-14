<?php
if (isset($_POST['identre']))
 {
        require_once 'db.php';
    $db = new Database();

    $identre = $_POST['identre'];

    $identre = $db->getEntryDetails($identre);

    if ($identre) {
        echo json_encode($identre);
    } else {
        echo json_encode(array('error' => 'Entrée non trouvée.'));
    }
} else {
    echo json_encode(array('error' => 'Aucun identifiant d\'entrée fourni.'));
}
?>
