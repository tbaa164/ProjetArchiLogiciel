<?php
require_once 'ConnexionManager.php';

class CategorieDao {
    public function getAllCategories() {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT id, libelle FROM Categorie";
        $result = $conn->query($sql);
        $categories = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }
}
?>
