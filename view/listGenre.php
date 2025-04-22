<?php ob_start(); // on commence chaque vue comme ça
?> 

<section class="list">
    <h2>Liste des genres</h2>
            <?php 
                foreach($requete->fetchAll() as $genre) { ?>
                    <p><a href="index.php?action=detailGenre&id=<?= $genre["id_genre"]?>"><?= $genre["nb_films"]." - ".$genre["nom_genre"] ?></a></p>
                </tr>
        <?php } ?>
</section>

<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Liste des genres";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";