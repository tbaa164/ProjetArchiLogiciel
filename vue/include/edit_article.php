
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Article</title>
    <style>

    </style>
</head>
<body>
    <h1>Modifier Article</h1>
    <form action="index.php?action=edit_article&id=<?= $article['id'] ?>" method="post">
        <label for="titre">Titre:</label><br>
        <input type="text" id="titre" name="titre" value="<?= $article['titre'] ?>"><br><br>
        
        <label for="contenu">Contenu:</label><br>
        <textarea id="contenu" name="contenu"><?= $article['contenu'] ?></textarea><br><br>
        
        <label for="categorie">Catégorie:</label><br>
        <select id="categorie" name="categorie">
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category['id'] ?>" <?= ($category['id'] == $article['categorie']) ? 'selected' : '' ?>><?= $category['libelle'] ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <button type="submit">Modifier</button>
    </form>
</body>
</html>
