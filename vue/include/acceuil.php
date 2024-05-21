
<div class="navbar">
    <a href="index.php">Accueil</a>
    <?php
    foreach ($categories as $categorie) {
        echo '<a href="index.php?categorie='.$categorie['id'].'">'.$categorie['libelle'].'</a>';
    }
    ?>
</div>
<div class="blanche">
         
</div>
<div class="articles-container">
    <?php
    foreach ($articles as $article) {
        echo '<div class="article">
                <h2>'.$article["titre"].'</h2>
                <p>'.$article["contenu"].'</p>
                <p>Catégorie: '.$article["categorie"].'</p>
              </div>';
    }
    ?>
</div>
