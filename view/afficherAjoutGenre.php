<?php ob_start(); // on commence chaque vue comme ça
?> 

<section class="add">
<div class="add_genre">
        <h2>AJOUTER UN GENRE</h2>
            <form action="index.php?action=ajouterGenre" method="post">
                <label for="nom_genre">Genre</label>
                    <input type="text" name="nom_genre" required>
            
            <input type="submit" name="submit" value="Ajouter le genre">
            </form>
    </div>
</section>
    
<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Ajouter genre";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";