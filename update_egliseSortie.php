<?php
require_once 'db.php';
$db = new Database();

$ancienSelectEglise = isset($_POST['ancienSelectEglise']) ? $_POST['ancienSelectEglise'] : '';
$ancienMontantsortie = isset($_POST['ancienMontantsortie']) ? $_POST['ancienMontantsortie'] : '';

if (!empty($ancienSelectEglise) && !empty($ancienMontantsortie)) {
    $db->updateEgliseSortieAgain($ancienSelectEglise, $ancienMontantsortie);
    echo "Mise à jour de la table eglise réussie !";
} else {
    echo "Données manquantes pour la mise à jour de la table eglise.";
}
?>
