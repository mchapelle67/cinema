<?php ob_start(); // on commence chaque vue comme ça
?>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom<th>
        </tr>
    <thead>
    <tbody>
        <?php 
            foreach($requete->fetchAll() as $real) { ?>
             <tr> 
                <td><?= $real["nom"] ?></td>
                <td><?= $real["prenom"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php

// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Details réalisateur";
$titre_secondaire = "Detail réalisateur";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";