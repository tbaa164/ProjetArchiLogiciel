<!DOCTYPE html>
<html>
<head>
    <title>Affichage des articles</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
<div class="head">
          <h1>Liste des articles</h1>
</div>



<?php
require_once 'controleur/controller.php';

$controller = new Controller();

if (isset($_GET['categorie']) && !empty($_GET['categorie'])) {
    $categorie_id = $_GET['categorie'];
    $controller->displayArticlesByCategorie($categorie_id);
} else {
    $controller->displayAccueil();
}
?>
