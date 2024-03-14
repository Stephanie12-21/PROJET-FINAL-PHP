<?php

require_once 'db.php';

$motif = isset($_POST['motif']) ? $_POST['motif'] : '';
$montant = isset($_POST['montant']) ? $_POST['montant'] : '';
$eglise = isset($_POST['eglise']) ? $_POST['eglise'] : '';
$entreid = isset($_POST['entreid']) ? $_POST['entreid'] : '';

if (!empty($motif) && !empty($montant) && !empty($eglise) && !empty($entreid)) 
{
    try {
        $db = new Database();

        $sql = "UPDATE sortie SET motifsortie = :motif, montantsortie = :montant, ideglise = :eglise, datesortie = CURRENT_TIMESTAMP WHERE idsortie = :entreid";
        $stmt = $db->getConnection()->prepare($sql);
        $stmt->bindParam(':motif', $motif);
        $stmt->bindParam(':montant', $montant);
        $stmt->bindParam(':eglise', $eglise);
        $stmt->bindParam(':entreid', $entreid);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Mise à jour réussie !";
        } else {
            echo "Aucune modification effectuée.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} 
else
 {
    echo "Toutes les données nécessaires ne sont pas fournies.";
}
?>
