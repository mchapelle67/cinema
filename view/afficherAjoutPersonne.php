<?php ob_start(); // on commence chaque vue comme ça
?> 

<section class="add">
    <div class="add_perso">
        <h2>AJOUTER UN REALISATEUR</h2>
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

                <label for="photo">Photo</label>
                    <input type="text" name="photo"> 

                <input type="submit" name="submit" value="AJOUTER">
                    
            </form>
    </div>
<?php
// dans chaque vue ces variables doivent avoir une valeur 
$titre = "Ajouter personne";
$titre_secondaire = "";
$contenu = ob_get_clean(); // on termine chaque vue comme ça, ça permet d'aspirer tout ce qui se trouve entre ces 2 fonctions
// (temporisation de sortie) pour stocker le contenu dans une variable $contenu
require "view/template.php";