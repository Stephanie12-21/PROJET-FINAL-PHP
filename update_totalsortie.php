<?php
require_once 'db.php'; 

$db = new Database();

$total_sortie = $db->calculerSommeSortie();

echo $total_sortie;
?>
