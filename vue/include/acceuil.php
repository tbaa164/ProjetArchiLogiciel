<?php
require_once 'modele/dao/CategorieDao.php';

$categorieDao = new CategorieDao();
$categories = $categorieDao->getAllCategories();

// Exemple de récupération du nombre total d'articles (à adapter selon votre logique)
$totalArticles = 50; // Remplacez par la valeur réelle du nombre total d'articles

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$totalPages = ceil($totalArticles / 5); // Calcul du nombre total de pages

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
        <a href="index.php?action=manage_categories">Gérer les Catégories</a>
    </div>

    <!-- Articles filtrés par catégorie -->
    <?php foreach ($articles as $article) : ?>
        <div class="article">
            <h2><a href="index.php?action=detail&id=<?= $article['id'] ?>"><?= $article['titre'] ?></a></h2>
            <p><?= substr($article['contenu'], 0, 100) ?>...</p>
            <p>Catégorie: <?= $article['categorie'] ?></p>

        </div>
    <?php endforeach; ?>

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
