<!DOCTYPE html>
<html>
<head>
    <title><?= isset($article['titre']) ? $article['titre'] : 'Titre non défini' ?></title>
</head>
<body>
    <?php if (!empty($article)) : ?>
        <h1><?= $article['titre'] ?></h1>
        <p><?= $article['contenu'] ?></p>
        <p>Catégorie: <?= $article['categorie'] ?></p>
    <?php else : ?>
        <p>L'article n'existe pas ou n'est pas disponible.</p>
    <?php endif; ?>
    <button onclick="window.location.href='index.php'">Retour à l'accueil</button>
</body>
</html>
