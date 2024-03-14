
<?php
require_once 'db.php';
$db = new Database();

$ancienSelectEglise = isset($_POST['ancienSelectEglise']) ? $_POST['ancienSelectEglise'] : '';
$ancienMontantentre = isset($_POST['ancienMontantentre']) ? $_POST['ancienMontantentre'] : '';

if (!empty($ancienSelectEglise) && !empty($ancienMontantentre)) {
    $db->updateEgliseAgain($ancienSelectEglise, $ancienMontantentre);
    echo "Mise à jour de la table eglise réussie !";
} else {
    echo "Données manquantes pour la mise à jour de la table eglise.";
}
?>
