<?php ob_start(); // on commence chaque vue comme ça
?> 

    <section class="list">
    <h2>Liste des réalisateurs</h2>
            <?php 
                foreach($requete->fetchAll() as $realisateur) { ?>
                    <p><a href="index.php?action=detailRealisateur&id=<?= $realisateur["id_real"] ?>"><?= $realisateur["prenom"]." ".$realisateur["nom"] ?></a></p>
                </tr>
            <?php } ?>
    </section>

<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Liste des realisateurs";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";