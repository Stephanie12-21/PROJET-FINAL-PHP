<?php
class Database
{
    private $dsn = "mysql:host=localhost;dbname=dbeglise";
    private $user = "root";
    private $pass = "";
    public $conn;

    public function __construct()
    {
        try
        {
            $this->conn = new PDO($this->dsn,$this->user,$this->pass);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    public function getConnection() {
        return $this->conn;
    }
    public function inserteglise($designeglise)
    {
        $sql = "INSERT INTO eglise(designeglise) VALUES (:designeglise)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['designeglise'=>$designeglise]);

        return true;
    }

    
    public function checkEgliseExists($designeglise)
    {
        $query = "SELECT * FROM eglise WHERE designeglise = :designeglise";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':designeglise', $designeglise);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function readeglise()
    {
        $sql = "SELECT * FROM eglise";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row)
        {
            $data[] = $row;
        }
        return $data;
    }
   
   public function getUserById($ideglise) 
   {
        $sql = "SELECT * FROM eglise WHERE ideglise = :ideglise";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ideglise' => $ideglise]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
   }
   
   public function updateEglise($ideglise, $designeglise)
   {
        $sql = "UPDATE eglise SET designeglise = :designeglise WHERE ideglise = :ideglise";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['designeglise' => $designeglise, 'ideglise' => $ideglise]);
        return true;
   }

    public function deleteEglise($ideglise)
    {
            $sql = "DELETE FROM eglise WHERE ideglise = :ideglise";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['ideglise' => $ideglise]);
            return true;
    }

   public function totalRowCount()
   {
        $sql = "SELECT * FROM eglise";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $t_rows = $stmt->rowCount();

        return $t_rows;
   }

    public function updateEgliseAgain($ancienSelectEglise, $ancienMontantentre)
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("SELECT soldeeglise FROM eglise WHERE ideglise = :ideglise");
            $stmt->bindParam(':ideglise', $ancienSelectEglise);
            $stmt->execute();
            $soldeeglise = $stmt->fetchColumn();

            $nouveauSolde = $soldeeglise - $ancienMontantentre;

            $stmt = $this->conn->prepare("UPDATE eglise SET soldeeglise = :nouveauSolde WHERE ideglise = :ideglise");
            $stmt->bindParam(':nouveauSolde', $nouveauSolde);
            $stmt->bindParam(':ideglise', $ancienSelectEglise);
            $stmt->execute();

            $this->conn->commit();

            return true;
        } catch (PDOException $e) {
        
            $this->conn->rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function updateEgliseSortieAgain($ancienSelectEglise, $ancienMontantsortie)
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("SELECT soldeeglise FROM eglise WHERE ideglise = :ideglise");
            $stmt->bindParam(':ideglise', $ancienSelectEglise);
            $stmt->execute();
            $soldeeglise = $stmt->fetchColumn();

            $nouveauSolde = $soldeeglise + $ancienMontantsortie;

            $stmt = $this->conn->prepare("UPDATE eglise SET soldeeglise = :nouveauSolde WHERE ideglise = :ideglise");
            $stmt->bindParam(':nouveauSolde', $nouveauSolde);
            $stmt->bindParam(':ideglise', $ancienSelectEglise);
            $stmt->execute();

            $this->conn->commit();

            return true;
        } catch (PDOException $e) {
        
            $this->conn->rollBack();
            echo $e->getMessage();
            return false;
        }
    }

####################################################################################################################
    public function calculerSommeEntree() 
    {
        try {
            $query = "SELECT SUM(montantentre) AS total FROM entre";

            $stmt = $this->getConnection()->query($query);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['total'])) {
                return $result['total'];
            } else {
                return 0; 
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function totalRowCountE()
    {
            $sql = "SELECT * FROM entre";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $t_rows = $stmt->rowCount();

            return $t_rows;
    }
    public function readentre()
    {
        $sql = "SELECT * FROM entre";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function deleteEntrance($identre) 
    {
        $sql = "DELETE FROM entre WHERE identre = :identre";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['identre' => $identre]);
        return true; 
    }

    public function getEntryDetails($identre) 
    {
        $sql = "SELECT * FROM entre WHERE identre = :identre";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['identre' => $identre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateSoldeEglise($ideglise, $nouveauSolde) 
    {
        $sql = "UPDATE eglise SET soldeeglise = :nouveauSolde WHERE ideglise = :ideglise";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['nouveauSolde' => $nouveauSolde, 'ideglise' => $ideglise]);
        return true;
    }
   
    public function filterEntriesByMotifentre($motifentre) 
    {
        try {
            $query = "SELECT * FROM entre WHERE motifentre LIKE ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(["%$motifentre%"]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    public function searchEntre($motifentre) 
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM entre WHERE motifentre LIKE :motifentre");
            $stmt->bindValue(':motifentre', '%' . $motifentre . '%', PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function searchEntreByDate($dateStart, $dateEnd) 
    {
        $query = "SELECT * FROM entree WHERE dateentre BETWEEN :dateStart AND :dateEnd";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindValue(':dateStart', $dateStart);
        $stmt->bindValue(':dateEnd', $dateEnd);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function fetchData()
    {
        $sql = "SELECT motifentre, montantentre, dateentre FROM entre";
        $stmt = $this->conn->query($sql);

        if ($stmt->rowCount() > 0) {
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array(); 
        }
    }

####################################################################################################################
    public function calculerSommeSortie() 
    {
        try {
            $query = "SELECT SUM(montantsortie) AS total FROM sortie";

            $stmt = $this->getConnection()->query($query);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['total'])) {
                return $result['total'];
            } else {
                return 0; 
            }
        } catch (PDOException $e) {
            
            return false;
        }
    }
    public function totalRowCountS()
    {
        $sql = "SELECT * FROM sortie";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $t_rows = $stmt->rowCount();

        return $t_rows;
    }
    public function readsortie()
    {
        $sql = "SELECT * FROM sortie";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row)
        {
            $data[] = $row;
        }
        return $data;
    }
   
    public function getSortieDetails($idsortie) 
    {
        $sql = "SELECT * FROM sortie WHERE idsortie = :idsortie";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['idsortie' => $idsortie]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateSoldeEglise2($ideglise, $nouveauSolde2) 
    {
        $sql = "UPDATE eglise SET soldeeglise = :nouveauSolde2 WHERE ideglise = :ideglise";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['nouveauSolde2' => $nouveauSolde2, 'ideglise' => $ideglise]);
        return true;
    }
  
    public function deleteSortie($idsortie) 
    {
        $sql = "DELETE FROM sortie WHERE idsortie = :idsortie";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['idsortie' => $idsortie]);
        return true; 
    }

    public function addSortie($motifsortie, $montantsortie, $ideglise) 
    {
        $sql = "INSERT INTO sortie (motifsortie, montantsortie, ideglise) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", $motifsortie, $montantsortie, $ideglise);

        $result = $stmt->execute();

        return $result;
    }
   
    
    public function getSortiesByMotif($motifsortie) 
    {
        $query = "SELECT * FROM sortie WHERE motifsortie LIKE :motifsortie";
        
        $stmt = $this->conn->prepare($query);
        
        $motifsortie = "%$motifsortie%";
        
        $stmt->bindParam(':motifsortie', $motifsortie, PDO::PARAM_STR);
        
        $stmt->execute();
        
        $sorties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $sorties;
    }


    public function fetchData2()
    {
        $sql = "SELECT motifsortie, montantsortie, datesortie FROM sortie";
        $stmt = $this->conn->query($sql);

        if ($stmt->rowCount() > 0) {
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array(); 
        }
    }

    public function searchEntreByDate2($dateStart, $dateEnd) {
        $query = "SELECT * FROM sortie WHERE datesortie BETWEEN :dateStart AND :dateEnd";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindValue(':dateStart', $dateStart);
        $stmt->bindValue(':dateEnd', $dateEnd);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

}

?>
