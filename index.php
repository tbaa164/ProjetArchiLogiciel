<?php
require 'vendor/autoload.php';

session_set_cookie_params([
    'lifetime' => 0,  // expire lorsque le navigateur est fermé
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();
require_once 'controleur/controller.php';
require_once 'Auth.php';

$controller = new Controller();

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : null; // Ajout de la définition de $id

switch ($action) {
    case 'home':
        $controller->displayHome($page);
        break;
    case 'filter':
        if ($categoryId) {
            $controller->filterArticlesByCategory($categoryId);
        } else {
            $controller->displayHome($page);
        }
        break;
    case 'detail':
        $controller->displayArticleDetail($id);
        break;
    case 'categorie':
        $controller->displayArticlesByCategorie($id);
        break;
    case 'manage_articles':
        $controller->displayManageArticles();
        break;
    case 'add_article':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->addArticle();
        } else {
            $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
            $controller->displayAddArticle($categoryId);
        }
        break;
    case 'edit_article':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->editArticle($id);
        } else {
            $controller->displayEditArticle($id);
        }
        break;
    case 'delete_article':
        if (isset($_GET['id'])) {
            $controller->deleteArticle($id);
        }
        break;
    case 'manage_categories':
        $controller->displayManageCategories();
        break;
    case 'add_category':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->addCategory();
        } else {
            $controller->displayAddCategory();
        }
        break;
    case 'edit_category':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->editCategory($id);
        } else {
            $controller->displayEditCategory($id);
        }
        break;
    case 'delete_category':
        if (isset($_GET['id'])) {
            $controller->deleteCategory($id);
        }
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            if ($controller->authenticate($email, $password)) {
                header('Location: index.php');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
                include 'vue/include/login.php';
            }
        } else {
            include 'vue/include/login.php';
        }
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'manage_users':
        $controller->displayManageUsers();
        break;
    case 'add_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->addUser();
        } else {
            $controller->displayAddUser();
        }
        break;
        case 'edit_user':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->editUser($id); // Assurez-vous que $id est passé à la méthode editUser()
            } else {
                $controller->displayEditUser($id); // Assurez-vous que $id est passé à la méthode displayEditUser()
            }
            break;
    case 'delete_user':
        if (isset($_GET['id'])) {
            $controller->deleteUser($id);
        }
        break;
    default:
        $controller->displayHome($page);
        break;
}

// Si l'utilisateur n'est pas connecté et qu'il ne tente pas de se connecter, rediriger vers la page de connexion
if ($action !== 'login' && !$controller->isLoggedIn()) {
    header('Location: index.php?action=login');
    exit;
}
?>
