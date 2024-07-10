<h2>Ajouter un Jeton pour</h2>
<?= htmlspecialchars($user['email']) ?>
<form action="index.php?action=add_token&id=<?= $user['id'] ?>" method="POST">
    <button type="submit">Générer et Ajouter Jeton</button>
    <p> Cela va generer un token et qui expire dans 1h</p>
</form>
