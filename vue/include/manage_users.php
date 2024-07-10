<h2>Gérer les utilisateurs</h2>
<a href="index.php?action=add_user">Ajouter un utilisateur</a>
<table style="border-collapse: collapse; width: 100%; border: 1px solid black;">
    <tr style="border: 1px solid black; text-align: left;">
        <th style="border: 1px solid black; padding: 8px;">Email</th>
        <th style="border: 1px solid black; padding: 8px;">Role</th>
        <th style="border: 1px solid black; padding: 8px;">Jeton</th>
        <th style="border: 1px solid black; padding: 8px;">ActionsTOKENS</th>
        <th style="border: 1px solid black; padding: 8px;">ActionsUSERS</th>
    </tr>
    <?php foreach ($utilisateurs as $user): ?>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding: 8px;"><?= htmlspecialchars($user['email']) ?></td>
        <td style="border: 1px solid black; padding: 8px;"><?= htmlspecialchars($user['role']) ?></td>
        <td style="border: 1px solid black; padding: 8px;">
            <?php if (!empty($user['tokens'])): ?>
                <ul>
                    <?php foreach ($user['tokens'] as $token): ?>
                        <li><?= htmlspecialchars($token['token']) ?> 
                        <a href="index.php?action=delete_token&user_id=<?= $user['id'] ?>&token=<?= $token['token'] ?>">Supprimer ce jeton</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                Aucun jeton
            <?php endif; ?>
        </td>
        <td style="border: 1px solid black; padding: 8px;">
            <a href="index.php?action=add_token&id=<?= $user['id'] ?>">Ajouter un jeton</a>
        </td>
        <td style="border: 1px solid black; padding: 8px;">
            <a href="index.php?action=edit_user&id=<?= $user['id'] ?>">Modifier Utilisateur</a>
            <a href="index.php?action=delete_user&id=<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer Utilisateur</a>
        </td>  
    </tr>
<?php endforeach; ?>
</table>
