<?php 

namespace Controller;
use Model\Connect; //permet d'accéder à la class Connect située dans le namespace Model

class CinemaController {
    
    // Lister les films
    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT titre, affiche_film , id_film
        FROM film
        ");
        //prépare et execute une requête SQL 
        require "view/listFilms.php"; //on relie la vue qui nous intéresse
    }
    
    // Lister les acteurs
    public function listActeurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT nom, prenom, acteur.id_acteur AS id_acteur
        FROM acteur
        INNER JOIN personne ON acteur.id_personne = personne.id_personne
        ");
        require "view/listActeurs.php"; 
    }

    // Lister les réalisateurs
    public function listRealisateurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT nom, prenom, realisateur.id_realisateur AS id_real
        FROM realisateur
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        ");
        require "view/listRealisateurs.php"; 
    }

    // Afficher les details des films
    public function detailFilm($id) {
        $pdo = Connect::seConnecter();
        // $requeteFilm = $pdo->prepare("
        // SELECT 
        // titre, synopsis, duree, note, annee_sortie, affiche_film,
        // nom, prenom,
        // nom_genre
        // FROM film
        // INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur 
        // INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        // INNER JOIN acteur ON personne.id_personne = acteur.id_personne 
        // INNER JOIN film_genre ON film.id_film = film_genre.id_film
        // INNER JOIN genre ON film_genre.id_genre = genre.id_genre
        // WHERE film.id_film = :id 
        // ");
        $requeteFilm = $pdo->prepare("
        SELECT 
        titre, synopsis, duree, note, annee_sortie, affiche_film,
        nom, prenom,
        nom_genre
        FROM film
        LEFT JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur 
        LEFT JOIN personne ON realisateur.id_personne = personne.id_personne
        LEFT JOIN acteur ON personne.id_personne = acteur.id_personne 
        LEFT JOIN film_genre ON film.id_film = film_genre.id_film
        LEFT JOIN genre ON film_genre.id_genre = genre.id_genre
        WHERE film.id_film = :id
");
        $requeteFilm->execute(['id'=> $id]);
    
        $requeteActeur = $pdo->prepare("
        SELECT prenom, nom, acteur.id_acteur AS id_acteur
        FROM film
        INNER JOIN casting ON film.id_film = casting.id_film
        INNER JOIN acteur ON casting.id_acteur = acteur.id_acteur
        INNER JOIN personne ON acteur.id_personne = personne.id_personne
        WHERE film.id_film = :id
        ");
        $requeteActeur->execute(['id'=> $id]);
        
        $requeteReal = $pdo->prepare("
        SELECT prenom, nom, realisateur.id_realisateur AS id_real
        FROM film
        INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        WHERE film.id_film = :id
        ");
        $requeteReal->execute(['id'=> $id]);
        
        $requeteGenre = $pdo->prepare("
        SELECT nom_genre, genre.id_genre AS id_genre
        FROM film
        INNER JOIN film_genre ON film.id_film = film_genre.id_film
        INNER JOIN genre ON film_genre.id_genre = genre.id_genre
        WHERE film.id_film = :id
        ");
        $requeteGenre->execute(['id'=> $id]);
        
        $genres = $requeteGenre->fetchAll();
        $realisateur = $requeteReal->fetch();
        $acteurs = $requeteActeur->fetchAll();
        $film = $requeteFilm->fetch();
        require "view/detailFilm.php";
    }

    // Afficher detail acteur 
    public function detailActeur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        SELECT nom, prenom, sexe, dateDeNaissance, personne.photo AS photo,
        titre, film.id_film AS id_film,
        nom_role
        FROM film
        INNER JOIN casting ON film.id_film = casting.id_film
        INNER JOIN acteur ON casting.id_acteur = acteur.id_acteur
        INNER JOIN personne ON acteur.id_personne = personne.id_personne
        INNER JOIN role ON casting.id_role = role.id_role
        WHERE acteur.id_acteur = :id 
        ");
        $requete->execute(['id'=> $id]);
        $acteur = $requete->fetch();       
        require "view/detailActeur.php";
    }
 
    // Afficher détail réalisateur
    public function detailRealisateur($id) {
        $pdo = Connect::seConnecter();
        $requeteReal = $pdo->prepare("
        SELECT nom, prenom, sexe, dateDeNaissance, 
        personne.photo AS photo,
        film.id_film AS id_film, titre
        FROM film
        INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        WHERE realisateur.id_realisateur = :id 
        ");
        $requeteReal->execute(['id'=> $id]);

        // $requeteFilm = $pdo->prepare("
        // SELECT film.id_film AS id_film, titre
        // FROM film
        // WHERE film.id_film = :id 
        // ");
        // $requeteFilm->execute(['id'=> $id]);

        // $films = $requeteFilm->fetchAll();
        $realisateur = $requeteReal->fetch();
        require "view/detailRealisateur.php";
    }

     // Lister les genres
        public function listGenres() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT nom_genre, COUNT(film_genre.id_genre) AS nb_films, genre.id_genre AS id_genre
        FROM film_genre 
        INNER JOIN genre ON film_genre.id_genre = genre.id_genre
        GROUP BY film_genre.id_genre
        ");
        require "view/listGenre.php"; 
    }

    // Afficher les films d'un genre 
    public function detailGenre($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        SELECT nom_genre
        FROM genre 
        WHERE genre.id_genre = :id
        ");
        $requete->execute(['id'=> $id]);

        $requeteFilms = $pdo->prepare("
        SELECT titre, film.id_film AS id_film
        FROM film
        INNER JOIN film_genre ON film.id_film = film_genre.id_film
        INNER JOIN genre ON film_genre.id_genre = genre.id_genre
        WHERE genre.id_genre = :id
        ");
        $requeteFilms->execute(['id'=> $id]);

        $requeteDelete = $pdo->prepare("
        DELETE FROM genre 
        WHERE genre.id_genre = :id
        ");
        $requeteDelete->execute(['id'=> $id]);

        $genre = $requete->fetch();
        $films = $requeteFilms->fetchAll();
        require "view/detailGenre.php"; 
    }

}