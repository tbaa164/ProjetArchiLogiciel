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
