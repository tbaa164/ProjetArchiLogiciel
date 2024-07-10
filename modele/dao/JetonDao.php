<?php
require_once 'ConnexionManager.php';

class JetonDao {
    public function ajouterJeton($utilisateurId, $token, $expiresAt) {
        $conn = ConnexionManager::getConnexion();
        $sql = "INSERT INTO Jeton (utilisateur_id, token, expires_at) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $utilisateurId, $token, $expiresAt);
        $stmt->execute();
    }

    public function supprimerJeton($id) {
        $conn = ConnexionManager::getConnexion();
        $sql = "DELETE FROM Jeton WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
    }

    public function getJetonByToken($token) {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT * FROM Jeton WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function supprimerJetonsExpirés() {
        $conn = ConnexionManager::getConnexion();
        $sql = "DELETE FROM Jeton WHERE expires_at < NOW()";
        $conn->query($sql);
    }
}
?>
