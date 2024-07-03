<!-- vue/include/manage_categories.php -->

<h2>Gérer les catégories</h2>
<a href="index.php?action=add_category">Ajouter une catégorie</a>
<table>
    <thead>
        <tr>
            <th>Libellé</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
        <tr>
            <td><?php echo htmlspecialchars($category['libelle']); ?></td>
            <td>
                <a href="index.php?action=edit_category&id=<?php echo $category['id']; ?>">Modifier</a>
                <a href="index.php?action=delete_category&id=<?php echo $category['id']; ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
