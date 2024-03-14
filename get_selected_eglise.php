<?php
require_once 'db.php';
$db = new Database();

if (isset($_GET['ideglise'])) {
    $ideglise = $_GET['ideglise'];
    $eglise = $db->getUserById($ideglise);
    if ($eglise) {
        echo $eglise['designeglise'];
    } else {
        echo "Église non trouvée";
    }
}
?>