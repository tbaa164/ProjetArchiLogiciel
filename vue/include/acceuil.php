<?php
require_once 'modele/dao/CategorieDao.php';
require_once 'modele/dao/ArticleDao.php';
require_once 'Auth.php'; 

$categorieDao = new CategorieDao();
$articleDao = new ArticleDao(); 

$categories = $categorieDao->getAllCategories();
$page = isset($_GET['page']) ? $_GET['page'] : 1;

//récupération du nombre total d'articles 
$totalArticles = $articleDao->getTotalArticlesCount();
$totalPages = ceil($totalArticles / 5);

// Récupération des articles en fonction de la page actuelle
$articlesPerPage = 5;

// Vérification si une catégorie est spécifiée dans l'URL
if (isset($_GET['category'])) {
    $categoryId = $_GET['category'];
    $articles = $articleDao->getArticlesByCategory($categoryId);
} else {
    $articles = $articleDao->getArticlesByPage($page, $articlesPerPage);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <style>
        .categories-bar {
            margin-bottom: 20px;
        }
        .category-button {
            margin-right: 10px;
            cursor: pointer;
            padding: 5px 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .category-button:hover {
            background-color: #e0e0e0;
        }
        .article {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
        }
        .btn:hover {
            background-color: #0056b3;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Liste des articles</h1>

    <!-- Barre de navigation des catégories -->
    <div class="categories-bar">
        <button class="category-button" onclick="window.location.href='index.php?action=home'">Tous</button>
        <?php foreach ($categories as $category) : ?>
            <button class="category-button" onclick="window.location.href='index.php?action=filter&category=<?= $category['id'] ?>'"><?= $category['libelle'] ?></button>
        <?php endforeach; ?>
        <!-- Ajouter un lien pour gérer les catégories -->
        <?php if (Auth::isEditor() || Auth::isAdmin()) : ?>
            <a href="index.php?action=manage_categories" class="btn">Gérer les Catégories</a>
        <?php endif; ?>
         <!-- Option pour gérer les utilisateurs si l'utilisateur est administrateur -->
    <?php if (Auth::isAdmin()) : ?>
        <div>
            <a href="index.php?action=manage_users" class="btn">Gérer les Utilisateurs</a>
        </div>
    <?php endif; ?>
    </div>

    <!-- Articles filtrés par catégorie ou tous les articles -->
    <?php if (!empty($articles)) : ?>
        <?php foreach ($articles as $article) : ?>
            <div class="article">
                <h2><a href="index.php?action=detail&id=<?= $article['id'] ?>"><?= $article['titre'] ?></a></h2>
                <p><?= substr($article['contenu'], 0, 100) ?>...</p>
                <p>Catégorie: <?= $article['categorie'] ?></p>

                <!-- Boutons pour modifier et supprimer -->
                <?php if (Auth::isEditor() || Auth::isAdmin()) :  ?>
                    <a href="index.php?action=edit_article&id=<?= $article['id'] ?>" class="btn">Modifier</a>
                    <a href="index.php?action=delete_article&id=<?= $article['id'] ?>" class="btn">Supprimer</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Aucun article trouvé.</p>
    <?php endif; ?>

    <!-- Bouton pour ajouter un article dans la catégorie courante -->
    <?php if (Auth::isAdmin() && isset($_GET['category'])) : ?>
        <a href="index.php?action=add_article&category=<?= $_GET['category'] ?>" class="btn btn-primary">Ajouter un article</a>
    <?php endif; ?>

    <!-- Pagination -->
    <div>
        <?php if ($page > 1) : ?>
            <button onclick="window.location.href='index.php?action=home&page=<?= $page - 1 ?>'">Précédent</button>
        <?php endif; ?>
        <?php if ($page < $totalPages) : ?>
            <button onclick="window.location.href='index.php?action=home&page=<?= $page + 1 ?>'">Suivant</button>
        <?php endif; ?>
    </div>

   
</body>
</html>
