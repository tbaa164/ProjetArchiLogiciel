<div class="navbar">
    <a href="index.php">Accueil</a>
    <?php foreach ($categories as $categorie) : ?>
        <a href="index.php?categorie=<?= $categorie['id'] ?>"><?= $categorie['libelle'] ?></a>
    <?php endforeach; ?>
    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'editeur' || $_SESSION['role'] == 'admin')): ?>
        <a href="index.php?action=manage_articles">Gérer les articles</a>
        <a href="index.php?action=manage_categories">Gérer les catégories</a>
    <?php endif; ?>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="index.php?action=manage_users">Gérer les utilisateurs</a>
    <?php endif; ?>
</div>

