<?php ob_start(); // on commence chaque vue comme ça
$formatter = new IntlDateFormatter(
    'fr_FR',              // langue + pays
    IntlDateFormatter::LONG, // format long : 21 avril 2025
    IntlDateFormatter::NONE // pas besoin de l'heure ici
);

$dateDeNaissance = $formatter->format(new DateTime($realisateur["dateDeNaissance"]));
 
if (isset($realisateur["sexe"]) && $realisateur["sexe"] == "M") {
    $realisateur["sexe"] = "Masculin";
    } else {
    $realisateur["sexe"] = "Feminin";
} 
?>

<section class="personne">
    <div class="photo">
        <h2><?= $realisateur["prenom"]." ".$realisateur["nom"] ?></h2>
    </div>
    <div class="photoPersonne">
        <img src="public/img/<?= $realisateur["photo"] ?>" alt="Photo acteur">
    </div>
    <div class="infosPersonne">
        <p>Date de naissance:</p> <?= $dateDeNaissance ?>
        <p>Sexe:</p> <?= $realisateur["sexe"] ?>
        <p>Filmographie:</p>
                <p><a href="index.php?action=detailFilm&id=<?= $realisateur["id_film"]?>"><?= $realisateur["titre"] ?></a></p>
    </div>
    
</section >

<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Detail réalisateur";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";