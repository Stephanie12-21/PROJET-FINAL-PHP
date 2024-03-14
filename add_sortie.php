<?php

require_once 'db.php';
$db = new Database();

if(isset($_POST['motifsortie']) && isset($_POST['montantsortie']) && isset($_POST['ideglise'])) {
    $motifsortie = $_POST['motifsortie'];
    $montantsortie = $_POST['montantsortie'];
    $ideglise = $_POST['ideglise'];

    if(empty($motifsortie) || empty($montantsortie) || empty($ideglise)) {
        echo "Tous les champs obligatoires doivent être remplis.";
    } else {
        try {
            $egliseDetails = $db->getUserById($ideglise);
            $soldeActuel = $egliseDetails['soldeeglise'];

            if ($soldeActuel > 10000) {
                $sql = "INSERT INTO sortie (motifsortie, montantsortie, ideglise, datesortie) VALUES (:motifsortie, :montantsortie, :ideglise, CURRENT_TIMESTAMP)";
                $stmt = $db->conn->prepare($sql);
                $stmt->bindParam(':motifsortie', $motifsortie);
                $stmt->bindParam(':montantsortie', $montantsortie);
                $stmt->bindParam(':ideglise', $ideglise);
            
                if($stmt->execute()) {
                    $nouveauSolde = $soldeActuel - $montantsortie;
                    $db->updateSoldeEglise($ideglise, $nouveauSolde);
            
                    echo "success";
                } else {
                    echo "Une erreur est survenue lors de l'ajout de la sortie.";
                }
            } else {
                echo "Le solde de l'église est insuffisant pour effectuer cette sortie.";
            }
            
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
} else {
    echo "Tous les champs requis doivent être fournis.";
}


?>









