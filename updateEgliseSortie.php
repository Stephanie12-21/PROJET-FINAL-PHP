<?php
require_once 'db.php';

$database = new Database();

$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['eglise']) && isset($_POST['montant'])) {
        $eglise = $_POST['eglise'];
        $montant = $_POST['montant'];

        $sql = "UPDATE eglise SET soldeeglise = soldeeglise - :montant WHERE ideglise = :eglise";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':montant', $montant, PDO::PARAM_INT);
        $stmt->bindParam(':eglise', $eglise, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "Erreur: Données manquantes.";
    }
} else {
    echo "Erreur: Méthode de requête non autorisée.";
}
?>
