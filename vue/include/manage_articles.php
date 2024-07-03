<!DOCTYPE html>
<html>
<head>
    <title>Gérer les articles</title>
</head>
<body>
    <h1>Gérer les articles</h1>
    <a href="index.php?action=add_article">Ajouter un article</a>
    <table>
        <tr>
            <th>Titre</th>
            <th>Catégorie</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($articles as $article) : ?>
            <tr>
                <td><?= $article['titre'] ?></td>
                <td><?= $article['categorie'] ?></td>
                <td>
                    <a href="index.php?action=edit_article&id=<?= $article['id'] ?>">Modifier</a>
                    <a href="index.php?action=delete_article&id=<?= $article['id'] ?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
