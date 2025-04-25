<?php ob_start(); // on commence chaque vue comme ça

// afficher la date de naissance en fr 
$formatter = new IntlDateFormatter(
    'fr_FR',              // langue + pays
    IntlDateFormatter::LONG, // format long : 21 avril 2025
    IntlDateFormatter::NONE // pas besoin de l'heure ici
);

$dateDeNaissance = $formatter->format(new DateTime($acteur["dateDeNaissance"]));

//  afficher le sexe 
if (isset($acteur["sexe"]) && $acteur["sexe"] == "M") {
        $acteur["sexe"] = "Masculin";
    } elseif (isset($acteur["sexe"]) && $acteur["sexe"] == "F") {
        $acteur["sexe"] = "Feminin";
    } else {
        $acteur["sexe"] = "Autre";
    };
?>

<section class="personne">
    <div class="photo">
        <h2><?= $acteur["prenom"]." ".$acteur["nom"] ?></h2>
    </div>
    <div class="photoPersonne">
        <img src="public/img/<?= $acteur["photo"] ?>" alt="Photo acteur">
    </div>
    <div class="infosPersonne">
        <p>Date de naissance:</p> <?= $dateDeNaissance ?>
        <p>Sexe:</p> <?= $acteur["sexe"] ?>
        <p>Rôle:</p> 
            <?php foreach ($requeteFilm->fetchAll() as $film) { ?>
                <p><?= $film["nom_role"]?> dans <a href="index.php?action=detailFilm&id=<?= $film["id_film"]?>"><?= $film["titre"] ?></a></p>
            <?php } ?>
    </div>
    
</section >

<?php


// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Detail Acteur";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";