<?php
require_once 'ConnexionManager.php';

class UtilisateurDao {
    public function getAllUtilisateurs() {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT id, nom, prenom, email, role FROM Utilisateur";
        $result = $conn->query($sql);
        $utilisateurs = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $utilisateurs[] = $row;
            }
        }
        return $utilisateurs;
    }

    public function ajouterUtilisateur($nom, $prenom, $email, $password, $role) {
        $conn = ConnexionManager::getConnexion();
        $sql = "INSERT INTO Utilisateur (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nom, $prenom, $email, $password, $role);
        $stmt->execute();
    }
    
    public function getUtilisateurByEmail($email) {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT * FROM Utilisateur WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // public function modifierUtilisateur($id, $nom, $prenom, $email, $password, $role) {
    //     $conn = ConnexionManager::getConnexion();
    //     $sql = "UPDATE Utilisateur
}