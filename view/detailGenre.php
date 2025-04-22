<?php ob_start(); // on commence chaque vue comme ça
?> 

<section class="list genre">
    <h2><?= $genre["nom_genre"] ?></h2>
            <?php 
                foreach($films as $film) { ?>
                    <p><a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>"><?= $film["titre"] ?></a></p>
                </tr>
        <?php } ?>
                    
    <h3><a href="http://localhost/manon_CHAPELLE/cinema/index.php?action=listGenre">Retour à la liste des genres</a></h3>
</section>

<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Liste des genres";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";