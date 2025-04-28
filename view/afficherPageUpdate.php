<?php ob_start(); 
?>


<section class="add">
    <div class="ajouter">
        <form action="index.php?action=updateFilm&id=<?= $film['id_film'] ?>" method="post">

               
           <p><label for="titre">Titre</label>
                <input type="text" name="titre" value="<?= $film["titre"] ?>"></p>
            <p><label for="synopsis">Synopsis</label>
                <textarea name="synopsis"><?= $film["synopsis"] ?></textarea></p>

            <p><label for="realisateur">Réalisateur</label>
                <select name="realisateur" id="realisateur">
                    <option value=""></option>
                    <?php foreach ($requeteReal->fetchAll() as $real) { ?>
                        <option value="<?= $real["id_realisateur"] ?>"><?= $real["prenom"]." ".$real["nom"] ?></option>
                    <?php } ?>
                </select></p>

            <p><label for="genres">Genre(s)</label>
                <select name="genres[]" id="genres" multiple> 
                    <?php foreach ($requeteGenre->fetchAll() as $genre) { ?>
                        <option value="<?= $genre["id_genre"] ?>"><?= $genre["nom_genre"] ?></option>
                    <?php } ?>
                </select></p>

            <p><label for="duree">Durée</label>
                <input type="number" name="duree" value="<?= $film["duree"] ?>"></p>

            <p><label for="note">Note</label>
                    <select name="note" id="note" value="<?= $film['note'] ?>">
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select></p>

            <p><label for="annee">Année sortie</label>
                    <input type="number" name="annee" min="1900" max="2050" step="1" value="<?= $film["annee_sortie"] ?>"></p>

            <div class="bouton_envoi">
                <input type="submit" name="submit" value="Modifier ce film">
            </div>
        </form>
    </div>
</section>

<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Modifier film";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";