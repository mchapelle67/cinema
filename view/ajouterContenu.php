<?php ob_start(); // on commence chaque vue comme ça
?> 

<section class="ajouterContenus">
        <h2><a href="index.php?action=afficherAjoutFilm">AJOUTER UN FILM</a></h2>

        <h2><a href="index.php?action=afficherAjoutPersonne">AJOUTER UN REALISATEUR</a></h2>
        
        <h2><a href="index.php?action=afficherAjoutGenre">AJOUTER UN GENRE</a></h2>  
</section>


<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Ajouter";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";