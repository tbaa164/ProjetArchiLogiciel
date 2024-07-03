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

    public function ajouterCategorie($libelle) {
        $conn = ConnexionManager::getConnexion();
        $sql = "INSERT INTO Categorie (libelle) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $libelle);
        $stmt->execute();
    }

    public function modifierCategorie($id, $libelle) {
        $conn = ConnexionManager::getConnexion();
        $sql = "UPDATE Categorie SET libelle = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $libelle, $id);
        $stmt->execute();
    }

    public function supprimerCategorie($id) {
        $conn = ConnexionManager::getConnexion();
        $sql = "DELETE FROM Categorie WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function getCategorieById($id) {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT id, libelle FROM Categorie WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
