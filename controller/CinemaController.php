<?php 

namespace Controller;
use Model\Connect; //permet d'accéder à la class Connect située dans le namespace Model

class CinemaController {

    // lister les films 
    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT titre, affiche_film 
        FROM film
        ");
         //prépare et execute une requête SQL 
        // var_dump($requete);
        require "view/listFilms.php"; //on relie la vue qui nous intéresse
    }

    public function detailActeur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        SELECT nom, prenom, sexe, date_de_naissance
        FROM personne
        INNER JOIN acteur ON acteur.id_personne = personne.id_personne
        WHERE id_acteur = :id 
        ");
        $requete->execute(['id'=> $id]);
        require "view/detailActeur.php";
    }

    public function listReal($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        SELECT nom, prenom, sexe, date_de_naissance
        FROM personne
        INNER JOIN realisateur ON realisateur.id_personne = personne.id_personne
        WHERE id_realisateur = :id 
        ");
        $requete->execute(['id'=> $id]);
        require "view/listReal.php";
    }
    
    public function detailFilm($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        SELECT titre, duree, synopsis, annee_sortie
        FROM FILM
        WHERE id_film = :id 
        ");
        $requete->execute(['id'=> $id]);
        require "view/detailFilm.php";
    }
}