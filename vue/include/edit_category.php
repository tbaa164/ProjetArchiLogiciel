
<h2>Modifier une catégorie</h2>
<form method="post" action="index.php?action=edit_category&id=<?php echo $categorie['id']; ?>">
    <label for="libelle">Libellé de la catégorie :</label>
    <input type="text" id="libelle" name="libelle" value="<?php echo htmlspecialchars($categorie['libelle']); ?>" required>
    <button type="submit">Modifier</button>
</form>
<a href="index.php?action=manage_categories">Retour à la gestion des catégories</a>
