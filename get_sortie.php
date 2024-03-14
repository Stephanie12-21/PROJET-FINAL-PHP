<?php
if (isset($_POST['idsortie'])) {
    require_once 'db.php';
    $db = new Database();

    $idsortie = $_POST['idsortie'];

    $idsortie = $db->getSortieDetails($idsortie);

    if ($idsortie) {
        echo json_encode($idsortie);
    } else {
        echo json_encode(array('error' => 'Sortie non trouvée.'));
    }
} else {
    echo json_encode(array('error' => 'Aucun identifiant de sortie fourni.'));
}
?>