<?php


require_once 'db.php';
$db = new Database();

if(isset($_POST['motifentre']) && isset($_POST['montantentre']) && isset($_POST['ideglise'])) {
    
    $motifentre = $_POST['motifentre'];
    $montantentre = $_POST['montantentre'];
    $ideglise = $_POST['ideglise'];


    if(empty($motifentre) || empty($montantentre) || empty($ideglise)) {
        echo "Tous les champs obligatoires doivent être remplis.";
    } else {
        try {
            $sql = "INSERT INTO entre (motifentre, montantentre, ideglise, dateentre) VALUES (:motifentre, :montantentre, :ideglise, CURRENT_TIMESTAMP)";
            $stmt = $db->conn->prepare($sql);
            $stmt->bindParam(':motifentre', $motifentre);
            $stmt->bindParam(':montantentre', $montantentre);
            $stmt->bindParam(':ideglise', $ideglise);

            if($stmt->execute()) {
                $update_sql = "UPDATE eglise SET soldeeglise = soldeeglise + :montantentre WHERE ideglise = :ideglise";
                $update_stmt = $db->conn->prepare($update_sql);
                $update_stmt->bindParam(':montantentre', $montantentre);
                $update_stmt->bindParam(':ideglise', $ideglise);

                $update_stmt->execute();

                echo "L'entrée a été ajoutée avec succès.";
            } else {
                echo "Une erreur est survenue lors de l'ajout de l'entrée.";
            }
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
} else {
    echo "Tous les champs requis doivent être fournis.";
}

?>




