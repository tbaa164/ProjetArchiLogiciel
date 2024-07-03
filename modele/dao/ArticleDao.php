<?php
require_once 'ConnexionManager.php';

class ArticleDao {
    public function getAllArticles() {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT a.id, a.titre, a.contenu, c.libelle AS categorie 
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

    public function getArticlesByPage($page, $articlesPerPage) {
        $conn = ConnexionManager::getConnexion();
        $offset = ($page - 1) * $articlesPerPage;
        $sql = "
            SELECT a.*, c.libelle as categorie_libelle
            FROM Article a
            LEFT JOIN Categorie c ON a.categorie = c.id
            ORDER BY a.dateCreation DESC
            LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $articlesPerPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $articles = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
        return $articles;
    }

    public function getTotalArticlesCount() {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT COUNT(*) as count FROM Article";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['count'];
    }


    public function getArticlesByCategory($categoryId) {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT id, titre, contenu, dateCreation, dateModification, categorie 
                FROM Article 
                WHERE categorie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $articles = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
        return $articles;
    }
    public function getArticleById($article_id) {
        $conn = ConnexionManager::getConnexion();
        $sql = "SELECT a.id, a.titre, a.contenu, c.libelle AS categorie 
                FROM Article a
                INNER JOIN Categorie c ON a.categorie = c.id
                WHERE a.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $article_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function ajouterArticle($titre, $contenu, $categorie_id) {
        $conn = ConnexionManager::getConnexion();
        $sql = "INSERT INTO Article (titre, contenu, categorie) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $titre, $contenu, $categorie_id);
        $stmt->execute();
    }

    public function modifierArticle($id, $titre, $contenu, $categorie_id) {
        $conn = ConnexionManager::getConnexion();
        $sql = "UPDATE Article SET titre = ?, contenu = ?, categorie = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $titre, $contenu, $categorie_id, $id);
        $stmt->execute();
    }

    public function supprimerArticle($id) {
        $conn = ConnexionManager::getConnexion();
        $sql = "DELETE FROM Article WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>
