<?php ob_start(); // on commence chaque vue comme ça
?> 

<section class="add">
    <div class="add_film">
    </div>
    <div class="add_perso">
    </div>
</section>

<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Ajouter contenu";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";