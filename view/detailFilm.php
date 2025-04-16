<?php ob_start(); // on commence chaque vue comme ça
?> 

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Année de sortie<th>
        </tr>
    <thead>
    <tbody>
        <?php 
            foreach($requete->fetchAll() as $film) { ?>
             <tr> 
                <td><?= $film["titre"] ?></td>
                <td><?= $film["annee_sortie"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php

// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Détail film";
$titre_secondaire = "Détail film";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";