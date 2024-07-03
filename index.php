<?php
session_start();
require_once 'controleur/Controller.php';
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
            $controller->displayAddArticle();
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
    default:
        $controller->displayHome($page);
        break;
}
?>
