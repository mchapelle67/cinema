<?php ob_start(); // on commence chaque vue comme ça
?> 

<!-- <p>Il y a $requete->rowCount()films</p> -->


        <div class="listeFilms">
            <?php 
                foreach($requete->fetchAll() as $film) { ?>
                    <p><?= $film["titre"] ?></p>
                </tr>
        <?php } ?>

<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Liste des films";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";