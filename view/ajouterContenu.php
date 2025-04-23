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

            <label for="genre">Genre*</label>
                <select name="genre" id="genre" required> 
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

            <label for="synopsis">Synopsis</label>
                <textarea name="synopsis"></textarea>

            <label for="duree">Durée (mn)*</label>
                <input type="number" name="duree" required> 

            <label for="role">Rôle</label>
                <input type="text" name="role" required> 
            
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

    <div class="add_perso">
        <h2>AJOUTER UNE PERSONNE</h2>
            <form action="index.php?action=ajouterPersonne" method="post">
                <label for="nom">Nom*</label>
                    <input type="text" name="nom" required> 

                <label for="prenom">Prénom*</label>
                    <input type="text" name="prenom" required> 

                <label for="dateNaissance">Date de naissance</label>
                    <input type="date" name="dateNaissance">
                    
                <h3>Sexe</h3>
                <label for="femme">Femme</label>
                    <input type="radio" name="sexe" value="F" id="F"> 
                <label for="homme">Homme</label>
                    <input type="radio" name="sexe" value="H" id="H"> 
                <label for="autre">Autre</label>    
                    <input type="radio" name="sexe" value="A" id="A"> 

                <label for="film">Film</label>
                <select name="film" id="film">
                    <?php foreach ($requeteSelectFilm->fetchAll() as $selectFilm) { ?>
                            <option value="<?= $selectFilm["id_film"] ?>"><?= $selectFilm["titre"] ?></option>
                    <?php } ?>
                </select>
                
                <label for="realisateur">Réalisateur</label>
                    <input type="checkbox" name="realisateur" id="realisateur"> 
                <label for="acteur">Acteur</label>
                    <input type="checkbox" name="acteur" id="acteur"> 


                <input type="submit" name="submit" value="Ajouter la personne">
                    
            </form>
    </div>

    <div class="add_casting">
        <h2>AJOUTER UN CASTING</h2>
        <form action="index.php?action=" method="post">
            <label for="film">Film</label>
                <select name="casting_film" id="casting_film">
                    <?php foreach ($requeteCastingtFilm->fetchAll() as $selectFilm) { ?>
                        <option value="<?= $selectFilm["id_film"] ?>"><?= $selectFilm["titre"] ?></option>
                    <?php } ?>
                </select>

            <label for="acteur">Acteur</label>
                <select name="casting_acteur" id="casting_acteur">
                    <?php foreach ($requeteActeur->fetchAll() as $acteur) { ?>
                        <option value="<?= $acteur["id_acteur"] ?>"><?= $acteur["prenom"]." ".$acteur["nom"] ?></option>
                    <?php } ?>
                </select>

            <label for="role">Rôle</label>
                <select name="role" id="role">
                    <?php foreach ($requeteRole->fetchAll() as $role) { ?>
                        <option value="<?= $role["id_role"] ?>"><?= $role["nom_role"] ?></option>
                    <?php } ?>
                </select>
            
            <input type="submit" name="submit" value="Ajouter le casting">
        </form>
    </div>
                        

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
$titre = "Ajouter contenu";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";