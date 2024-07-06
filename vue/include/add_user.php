<form method="post" action="index.php?action=add_user">
    <label>Nom:</label>
    <input type="text" name="nom" value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>" required>
    <br>
    <label>Prénom:</label>
    <input type="text" name="prenom" value="<?= isset($prenom) ? htmlspecialchars($prenom) : '' ?>" required>
    <br>
    <label>Email:</label>
    <input type="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
    <br>
    <label>Mot de passe:</label>
    <input type="password" name="password">
    <br>
    <label>Role:</label>
    <select name="role">
        <option value="visitor" <?= isset($role) && $role === 'visitor' ? 'selected' : '' ?>>Visitor</option>
        <option value="editor" <?= isset($role) && $role === 'editor' ? 'selected' : '' ?>>Editor</option>
        <option value="admin" <?= isset($role) && $role === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
    <br>
    <input type="submit" value="Ajouter">
</form>
