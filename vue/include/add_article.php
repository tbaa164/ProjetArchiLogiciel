<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un article</title>
</head>
<body>
    <h1>Ajouter un article</h1>
    <form action="index.php?action=add_article" method="post">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required><br>
        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" required></textarea><br>
        <label for="categorie">Catégorie :</label>
        <select id="categorie" name="categorie">
            <?php foreach ($categories as $categorie) : ?>
                <option value="<?= $categorie['id'] ?>"><?= $categorie['libelle'] ?></option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
