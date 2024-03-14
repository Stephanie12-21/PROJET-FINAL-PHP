<?php
require_once 'db.php'; 

$db = new Database();

$total_entree = $db->calculerSommeEntree();

echo $total_entree;
?>
