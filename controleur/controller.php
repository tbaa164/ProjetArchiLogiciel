<?php
require_once 'modele/dao/ArticleDao.php';
require_once 'modele/dao/CategorieDao.php';
require_once 'modele/dao/UtilisateurDao.php';

class Controller {
    private $articleDao;
    private $categorieDao;
    private $utilisateurDao;

    public function __construct() {
        $this->articleDao = new ArticleDao();
        $this->categorieDao = new CategorieDao();
        $this->utilisateurDao = new UtilisateurDao();
    }

    public function authenticate($email, $password) {
        $user = $this->utilisateurDao->getUtilisateurByEmail($email);
        if ($user && $password === $user['password']) { // Comparaison sans hachage
            Auth::login($user);
            return true;
        }
        return false;
    }

    public function displayLogin() {
        include 'vue/include/login.php';
    }

    public function logout() {
        Auth::logout();
        header('Location: index.php');
        exit;
    }

    public function displayManageCategories() {
        $this->checkAdmin(); // Vérifier si l'utilisateur est administrateur
        $categories = $this->categorieDao->getAllCategories();
        include 'vue/include/manage_categories.php';
    }

    private function checkAdmin() {
        if (!Auth::isLoggedIn()) {
            echo "L'utilisateur n'est pas connecté.";
        } elseif (!Auth::isAdmin()) {
            echo "L'utilisateur n'est pas administrateur.";
        } else {
            echo "L'utilisateur est administrateur.";
        }
    }

    public function displayHome($page = 1) {
        $articlesPerPage = 5;
        $articleDao = new ArticleDao();
        $articles = $articleDao->getArticlesByPage($page, $articlesPerPage);
        $totalArticles = $articleDao->getTotalArticlesCount();
        $totalPages = ceil($totalArticles / $articlesPerPage);
    
        require_once 'vue/include/acceuil.php';
    }

    public function filterArticlesByCategory($categoryId) {
        $articleDao = new ArticleDao();
        $articles = $articleDao->getArticlesByCategory($categoryId);
    
        require_once 'vue/include/acceuil.php';
    }

    public function displayAccueil($page = 1) {
        $categories = $this->categorieDao->getAllCategories();
        $articles = $this->articleDao->getArticlesByPage($page);
        include 'vue/include/acceuil.php';
    }

    public function displayArticleDetail($article_id) {
        $article = $this->articleDao->getArticleById($article_id);
        include 'vue/include/article_detail.php';
    }

    public function displayArticlesByCategorie($categorie_id) {
        $categories = $this->categorieDao->getAllCategories();
        $articles = $this->articleDao->getArticlesByCategorie($categorie_id);
        include 'vue/include/acceuil.php';
    }

    public function addArticle() {
        $this->checkEditor();
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $categorie = $_POST['categorie'];
        $this->articleDao->addArticle($titre, $contenu, $categorie);
        header('Location: index.php?action=manage_articles');
    }

    public function deleteArticle($id) {
        $this->articleDao->deleteArticle($id);
        $this->displayManageArticles();
    }

    private function checkEditor() {
        if (!Auth::isEditor()) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    public function displayManageArticles() {
        $this->checkEditor();
        $categories = $this->categorieDao->getAllCategories();
        $articles = $this->articleDao->getAllArticles();
        include 'vue/include/manage_articles.php';
    }

    public function displayAddArticle() {
        $this->checkEditor();
        $categories = $this->categorieDao->getAllCategories();
        include 'vue/include/add_article.php';
    }

    public function addCategory() {
        $this->checkAdmin();
        $libelle = $_POST['libelle'];
        $this->categorieDao->ajouterCategorie($libelle);
        header('Location: index.php?action=manage_categories');
    }

    public function displayAddCategory() {
        $this->checkAdmin();
        include 'vue/include/add_category.php';
    }

    public function displayEditCategory($id) {
        $this->checkAdmin();
        $categorie = $this->categorieDao->getCategorieById($id);
        include 'vue/include/edit_category.php';
    }

    public function editCategory($id) {
        $this->checkAdmin();
        $libelle = $_POST['libelle'];
        $this->categorieDao->modifierCategorie($id, $libelle);
        header('Location: index.php?action=manage_categories');
    }

    public function deleteCategory($id) {
        $this->checkAdmin();
        $this->categorieDao->supprimerCategorie($id);
        header('Location: index.php?action=manage_categories');
    }
}
?>






