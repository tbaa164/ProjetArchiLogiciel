<?php
require_once 'modele/dao/ArticleDao.php';
require_once 'modele/dao/CategorieDao.php';
require_once 'modele/dao/UtilisateurDao.php';
require_once 'modele/dao/JetonDao.php';
require_once 'JWT/JwtManager.php';

class Controller {
    private $articleDao;
    private $categorieDao;
    private $utilisateurDao;
    private $jwtManager;
    private $jetonDao;

    public function __construct() {
        $this->articleDao = new ArticleDao();
        $this->categorieDao = new CategorieDao();
        $this->utilisateurDao = new UtilisateurDao();
        $this->jwtManager = new JwtManager('b8e1f59c6e774a0c91f9d4b8a6d7e4a29cf9d4c4e8e7c6b1a8d9f9d2f8c9e2b4');
        $this->jetonDao = new JetonDao();
    }


    // public function authenticate($email, $password) {
    //     $user = $this->utilisateurDao->getUtilisateurByEmail($email);
    
    //     // Vérifiez si l'utilisateur existe et si le mot de passe correspond
    //     if ($user && $password === $user['password']) {
    //         // Authentification réussie, définir la session
    //         Auth::login($user);
    //         return true;
    //     }
    
    //     return false;
    // }

    public function authenticate($email, $password) {
        $user = $this->utilisateurDao->getUtilisateurByEmail($email);
    
        if ($user && $password === $user['password']) {
            $payload = [
                "id" => $user['id'],
                "email" => $user['email'],
                "role" => $user['role'],
                "exp" => time() + 3600  // Exemple: jeton valide pendant 1 heure
            ];
            $jwt = $this->jwtManager->createToken($payload);
            $this->jetonDao->ajouterJeton($user['id'], $jwt, date('Y-m-d H:i:s', $payload['exp']));
            $_SESSION['jwt'] = $jwt;
    
            header('Location: index.php?action=home');
            exit;
        }
    
        return "Adresse email ou mot de passe incorrect.";
    }
    
    public function logout() {
        session_start();
        $user = $this->utilisateurDao->getUtilisateurByEmail($_SESSION['email']); // Remplacez par votre méthode de récupération d'utilisateur par email
        if ($user) {
            $this->utilisateurDao->supprimerJeton($user['id']);
        }
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
    

    public function displayLogin() {
        include 'vue/include/login.php';
    }

    

    public function displayManageCategories() {
        $this->checkEditorOrAdmin(); 
        $categories = $this->categorieDao->getAllCategories();
        include 'vue/include/manage_categories.php';
    }

    private function checkEditorOrAdmin() {
        $userRole = Auth::getUserRole();
        if (!Auth::isLoggedIn()) {
            header('Location: index.php?action=login');
            exit;
        } elseif ($userRole !== 'editor' && $userRole !== 'admin') {
            echo "L'utilisateur n'est pas éditeur ou administrateur.";
            exit;
        }
    }

    public function displayAddArticle($categoryId = null) {
        $this->checkEditor();
        $categories = $this->categorieDao->getAllCategories();
        include 'vue/include/add_article.php';
    }

    public function displayHome($page = 1) {
        $articlesPerPage = 5;
        $articles = $this->articleDao->getArticlesByPage($page, $articlesPerPage);
        $totalArticles = $this->articleDao->getTotalArticlesCount();
        $totalPages = ceil($totalArticles / $articlesPerPage);

        include 'vue/include/acceuil.php';
    }

    public function filterArticlesByCategory($categoryId) {
        $articles = $this->articleDao->getArticlesByCategory($categoryId);
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
        header('Location: index.php?action=filter&category=' . $categorie);
    }

    public function displayEditArticle($id) {
        $this->checkEditor(); 
        $article = $this->articleDao->getArticleById($id);
        $categories = $this->categorieDao->getAllCategories();
        include 'vue/include/edit_article.php'; 
    }

    public function editArticle($id) {
        $this->checkEditor(); 
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $categorie_id = $_POST['categorie'];
        $this->articleDao->modifierArticle($id, $titre, $contenu, $categorie_id);
        header('Location: index.php?action=home');
    }

    public function deleteArticle($id) {
        $this->checkEditor(); 
        $this->articleDao->supprimerArticle($id);
        header('Location: index.php?action=home');
    }

    private function checkEditor() {
        $userRole = Auth::getUserRole();
        if (!Auth::isLoggedIn()) {
            header('Location: index.php?action=login');
            exit;
        } elseif ($userRole !== 'editor' && $userRole !== 'admin') {
            echo "L'utilisateur n'est pas éditeur ou administrateur.";
            exit;
        }
    }

    public function displayManageArticles() {
        $this->checkEditor();
        $categories = $this->categorieDao->getAllCategories();
        $articles = $this->articleDao->getAllArticles();
        include 'vue/include/manage_articles.php';
    }

    public function addCategory() {
        $this->checkEditorOrAdmin(); 
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

    public function isLoggedIn() {
        return Auth::isLoggedIn();
    }

    public function isAdmin() {
        $userRole = Auth::getUserRole();
        return $userRole === 'admin';
    }

    private function checkAdmin() {
        if (!Auth::isAdmin()) {
            header('Location: index.php?action=login');
            exit;
        }
    }
    

    public function displayManageUsers() {
        $this->checkAdmin();
        $utilisateurs = $this->utilisateurDao->getUtilisateurWithTokens();
        include 'vue/include/manage_users.php';
    }

    public function displayAddUser() {
        $this->checkAdmin();
        
       $nom = '';
        $prenom = '';
        $email = '';
        $role = ''; 
    
        include 'vue/include/add_user.php';
    }
    
    public function addUser() {
        $this->checkAdmin();
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $this->utilisateurDao->ajouterUtilisateur($nom, $prenom, $email, $password, $role);
        header('Location: index.php?action=manage_users');
    }

    public function displayEditUser($id) {
        $this->checkAdmin();
        $user = $this->utilisateurDao->getUtilisateurById($id);

        if (!$user) {
            echo "Utilisateur non trouvé.";
            exit;
        }

        include 'vue/include/edit_user.php';
    }

    public function editUser($id) {
        $this->checkAdmin();
    
        // Vérifiez si l'utilisateur existe
        $user = $this->utilisateurDao->getUtilisateurById($id);
    
        if (!$user) {
            echo "Utilisateur non trouvé.";
            exit;
        }
    
        // Si le formulaire est soumis, meu modifier l'user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
    
            // méthode pour modifier l'utilisateur dans UtilisateurDao
            $this->utilisateurDao->modifierUtilisateur($id, $nom, $prenom, $email, $password, $role);
    
            // Redirigez après modification
            header('Location: index.php?action=manage_users');
            exit;
        }
    
        // Afficher formulaire de modification avec les détails de l'utilisateur
        include 'vue/include/edit_user.php';
    }
    
    

    public function deleteUser($id) {
        $this->checkAdmin();
        $this->utilisateurDao->supprimerUtilisateur($id);
        header('Location: index.php?action=manage_users');
    }
   
    
    public function displayAddToken($userId) {
        $this->checkAdmin();
        $user = $this->utilisateurDao->getUtilisateurById($userId);
        include 'vue/include/add_token.php';
    }
    
    public function addToken($userId) {
        $this->checkAdmin();
    
        // Generate a JWT token
        $jwtManager = new JwtManager("b8e1f59c6e774a0c91f9d4b8a6d7e4a29cf9d4c4e8e7c6b1a8d9f9d2f8c9e2b4");
        $payload = array(
            'user_id' => $userId,
            'expires_at' => strtotime('+1 hour')  // Expiration à 1 heure
            // You can add more data as needed in the payload
        );
        $token = $jwtManager->createToken($payload);
    
        // Store the token and expiration in your database or token management system
        // Example assuming you have a method ajouterJeton($userId, $token, $expiresAt)
        $this->jetonDao->ajouterJeton($userId, $token, date('Y-m-d H:i:s', $payload['expires_at']));
    
        // Redirect or handle as needed
        header('Location: index.php?action=manage_users');
    }
    

    public function deleteToken($userId, $token) {
        $this->utilisateurDao->supprimerJeton($userId, $token);
        header('Location: index.php?action=manage_users');
        exit;
    }
    
    
  
    
    
 
}
?>
