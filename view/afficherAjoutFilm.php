<?php ob_start(); // on commence chaque vue comme ça
?> 

<section class="add">
    <div class="add_film">
        <h2>AJOUTER UN FILM</h2>

        <form action="index.php?action=ajouterFilm" method="post">
            <label for="titre">Titre*</label>
                <input type="text" name="titre" required> 

            <label for="annee">Année sortie*</label>
                <input type="number" name="annee" min="1900" max="2050" step="1" required>

            <label for="genres">Genres*</label>
                <select name="genres[]" id="genres" multiple required> 
                    <?php foreach ($requeteGenre->fetchAll() as $genre) { ?>
                        <option value="<?= $genre["id_genre"] ?>"><?= $genre["nom_genre"] ?></option>
                    <?php } ?>
                </select>

            <label for="realisateur">Réalisateur*</label>
                <select name="realisateur" id="realisateur" required>
                    <?php foreach ($requeteReal->fetchAll() as $real) { ?>
                            <option value="<?= $real["id_realisateur"] ?>"><?= $real["prenom"]." ".$real["nom"] ?></option>
                    <?php } ?>
                </select>

                <label for="duree">Durée (mn)*</label>
                    <input type="number" name="duree" required> 

            <label for="synopsis">Synopsis</label>
                <textarea name="synopsis"></textarea>

            <label for="role">Rôle</label>
                <input type="text" name="role"> 

            <label for="affiche">Affiche</label>
                <input type="text" name="affiche" placeholder="Ex: fichier.jpg"> 
            
            <label for="note">Note</label>
                <select name="note" id="note">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>

            <input type="submit" name="submit" value="Ajouter le film">
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