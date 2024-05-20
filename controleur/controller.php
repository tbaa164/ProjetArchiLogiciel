<?php
require_once 'modele/dao/ArticleDao.php';
require_once 'modele/dao/CategorieDao.php';

class Controller {
    private $articleDao;
    private $categorieDao;

    public function __construct() {
        $this->articleDao = new ArticleDao();
        $this->categorieDao = new CategorieDao();
    }

    public function displayAccueil() {
        $categories = $this->categorieDao->getAllCategories();
        $articles = $this->articleDao->getAllArticles();
        include 'vue/include/acceuil.php';
    }

    public function displayArticlesByCategorie($categorie_id) {
        $categories = $this->categorieDao->getAllCategories();
        $articles = $this->articleDao->getArticlesByCategorie($categorie_id);
        include 'vue/include/acceuil.php';
    }
}
?>
