<h2>Gérer les utilisateurs</h2>
<a href="index.php?action=add_user">Ajouter un utilisateur</a>
<table>
    <tr>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($utilisateurs as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
        <td>
            <a href="index.php?action=edit_user&id=<?= $user['id'] ?>">Modifier</a>
            <a href="index.php?action=delete_user&id=<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
            <a href="index.php?action=add_token&id=<?= $user['id'] ?>">Ajouter un jeton</a>
            <a href="index.php?action=delete_token&id=<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce jeton ?')">Supprimer le jeton</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
