<?php ob_start(); // on commence chaque vue comme ça
?> 

<section class="add">
    <div class="ajouter film">
        <h2>AJOUTER UN FILM</h2>

        <form action="index.php?action=ajouterFilm" method="post">
        
            <p><label for="titre">Titre*</label>
                <input type="text" name="titre" required></p>

            <p><label for="annee">Année sortie*</label>
                <input type="number" name="annee" min="1900" max="2050" step="1" required></p>

            <span class="info_form"><p><label for="genres">Genres*</label>
                <select name="genres[]" id="genres" multiple required> 
                    <?php foreach ($requeteGenre->fetchAll() as $genre) { ?>
                        <option value="<?= $genre["id_genre"] ?>"><?= $genre["nom_genre"] ?></option>
                        <?php } ?>
                </select></p></span>

            <span class="info_form"><p><label for="synopsis">Synopsis</label>
                <textarea name="synopsis"></textarea></p></span>

            <p><label for="duree">Durée (mn)*</label>
                <input type="number" name="duree" required></p>

            <span class="info_form"><p><label for="realisateur">Réalisateur*</label>
                <select name="realisateur" id="realisateur" required>
                    <?php foreach ($requeteReal->fetchAll() as $real) { ?>
                        <option value="<?= $real["id_realisateur"] ?>"><?= $real["prenom"]." ".$real["nom"] ?></option>
                    <?php } ?>
                </select></p></span>
        
            <p><label for="affiche">Affiche</label>
                <input type="text" name="affiche"></p>

            <span class="info_form"><p><label for="note">Note</label>
                <select name="note" id="note">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select></p></span>
    
        <div class="bouton_envoi">
            <input type="submit" name="submit" value="AJOUTER">  
        </div>
        </form>
    </div>
</section>


<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Ajouter film";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";