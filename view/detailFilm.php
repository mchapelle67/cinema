<?php ob_start(); 
?>

<section class="blocks">
<div class="contenair-synopsis-button">
    <div class="synopsis">
        <h2><?= $film["titre"] ?></h2>
        <p><?= $film["synopsis"] ?></p>
            <div class="buttons">
                <button class="button modifier" type="button"><a href="">Modifier ce film</a></button>
            </div>
    </div>
</div>

<div class="infos">
    <div class="info">
        <h3>ACTEURS</h3>
            <?php foreach($acteurs as $acteur) { ?>
                <p><a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"]?>"><?= $acteur["prenom"]." ".$acteur["nom"] ?></a></p>
            <?php }; ?>
    </div>

    <div class="info">
        <h3>RÉALISATEUR</h3>
            <p><a href="index.php?action=detailRealisateur&id=<?= $realisateur["id_real"]?>"><?= $realisateur["prenom"]." ".$realisateur["nom"] ?></a></p>
    </div>

    <div class="info">
        <h3>GENRE</h3>
            <?php foreach($genres as $genre) { ?>
                <p><a href="index.php?action=detailGenre&id=<?= $genre["id_genre"]?>"><?= $genre["nom_genre"] ?></a></p>
            <?php }; ?>
    </div>

    <div class="info">
        <h3>DURÉE<h3>
            <p><?=$film["duree"]?> mn</p>
    </div>

    <div class="info">
        <h3>NOTE</h3>
            <p><?=$film["note"]?></p>
    </div>

    <div class="info">
        <h3>DATE DE SORTIE</h3>
            <p><?=$film["annee_sortie"]?></p>
    </div>

    <a href="index.php?action=supprFilm&id=<?= $film['id_film']?> ">Supprimer ce film</a>
  
</div>
</section>

<?php

// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Détail film";
$titre_secondaire = "";
$page = "detailFilm"; 
$backgroundImage = $film['affiche_film'];
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";