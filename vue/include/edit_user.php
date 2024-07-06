

<h2>Modifier un utilisateur</h2>
<form method="post" action="index.php?action=edit_user&id=<?= $user['id'] ?>">
    <label>Nom:</label>
    <input type="text" name="nom" value="<?= isset($user['nom']) ? htmlspecialchars($user['nom']) : '' ?>" required>
    <br>
    <label>Prénom:</label>
    <input type="text" name="prenom" value="<?= isset($user['prenom']) ? htmlspecialchars($user['prenom']) : '' ?>" required>
    <br>
    <label>Email:</label>
    <input type="email" name="email" value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>" required>
    <br>
    <label>Mot de passe:</label>
    <input type="password" name="password">
    <br>
    <label>Role:</label>
    <select name="role">
        <option value="visitor" <?= isset($user['role']) && $user['role'] === 'visitor' ? 'selected' : '' ?>>Visitor</option>
        <option value="editor" <?= isset($user['role']) && $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
        <option value="admin" <?= isset($user['role']) && $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
    <br>
    <input type="submit" value="Modifier">
</form>
