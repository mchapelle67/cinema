<?php ob_start(); 
?>


<section class="add">
<div class="contenair-synopsis-button">
<form action="index.php?action=updateFilm" method="post">
    
    
    <div class="synopsis">
    <label for="titre">Titre</label>
        <input type="text" name="titre" placeholder="<?= $requeteFilm["titre"] ?>"> 
    <label for="synopsis">Synopsis</label>
        <textarea name="synopsis"></textarea>
    </div>
</div>

<div class="infos">
    <div class="info">
        <label for="acteur">Acteur(s)</label>
            <select name="acteur" id="acteur" multiple>
                <?php foreach ($requeteActeur->fetchAll() as $acteur) { ?>
                    <option value="<?= $acteur["id_realisateur"] ?>"><?= $acteur["prenom"]." ".$acteur["nom"] ?></option>
                <?php } ?>
            </select>
    </div>

<div class="info">
    <label for="realisateur">Réalisateur</label>
        <select name="realisateur" id="realisateur">
            <?php foreach ($requeteReal->fetchAll() as $real) { ?>
                <option value="<?= $real["id_realisateur"] ?>"><?= $real["prenom"]." ".$real["nom"] ?></option>
            <?php } ?>
        </select>
    </div>

<div class="info">
    <label for="genres">Genre(s)</label>
        <select name="genres[]" id="genres" multiple> 
            <?php foreach ($requeteGenre->fetchAll() as $genre) { ?>
                <option value="<?= $genre["id_genre"] ?>"><?= $genre["nom_genre"] ?></option>
            <?php } ?>
        </select>
</div>

<div class="info">
    <label for="duree">Durée</label>
        <input type="number" name="duree" value="<?= $requeteFilm['duree'] ?>"> 
</div>

    <div class="info">
        <label for="note">Note</label>
            <select name="note" id="note">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
    </div>

    <div class="info">
        <label for="annee">Année sortie</label>
            <input type="number" name="annee" min="1900" max="2050" step="1" value="<?= $requeteFilm['annee_sortie'] ?>">
    </div>
        <input type="submit" name="submit" value="Modifier ce film">
    </div>
</form>
</section>

<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Modifier film";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";