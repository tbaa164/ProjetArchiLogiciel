<?php
require_once 'ConnexionManager.php';

class ArticleDao {
    public function getAllArticles() {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT a.titre, a.contenu, c.libelle AS categorie 
                FROM Article a
                INNER JOIN Categorie c ON a.categorie = c.id";
        $result = $conn->query($sql);
        $articles = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
        return $articles;
    }

    public function getArticlesByCategorie($categorie_id) {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT a.titre, a.contenu, c.libelle AS categorie 
                FROM Article a
                INNER JOIN Categorie c ON a.categorie = c.id
                WHERE a.categorie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categorie_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $articles = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
        return $articles;
    }
}
?>
