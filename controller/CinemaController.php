<?php 

namespace Controller;
use Model\Connect; //permet d'accéder à la class Connect située dans le namespace Model

class CinemaController {
    
//****************************************** AFFICHAGE **************************************** */
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
    

// Lister les personnes
    public function listPersonnes() {
        $pdo = Connect::seConnecter();
        $requeteActeur = $pdo->query("
        SELECT nom, prenom, acteur.id_acteur AS id_acteur
        FROM acteur
        INNER JOIN personne ON acteur.id_personne = personne.id_personne
        ");

        $requeteReal = $pdo->query("
        SELECT nom, prenom, realisateur.id_realisateur AS id_real
        FROM realisateur
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        ");

        require "view/listPersonnes.php"; 
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

// Afficher les details des films
    public function detailFilm($id) {
        $pdo = Connect::seConnecter();
        $requeteFilm = $pdo->prepare("
        SELECT 
        film.id_film,titre, synopsis, duree, note, annee_sortie, affiche_film,
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

        $requeteFilm = $pdo->prepare("
        SELECT film.id_film, titre, nom_role
        FROM film 
        INNER JOIN casting ON film.id_film = casting.id_film
        INNER JOIN role ON casting.id_role = role.id_role
        WHERE casting.id_acteur = :id 
        ");
        $requeteFilm->execute(['id'=> $id]);

        $acteur = $requete->fetch();       
        require "view/detailActeur.php";
    }
 

// Afficher détail réalisateur
    public function detailRealisateur($id) {
        $pdo = Connect::seConnecter();
        $requeteReal = $pdo->prepare("
        SELECT nom, prenom, sexe, dateDeNaissance, personne.id_personne AS id_personne,
        personne.photo AS photo,
        film.id_film AS id_film, titre
        FROM film
        INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        WHERE realisateur.id_realisateur = :id 
        ");
        $requeteReal->execute(['id'=> $id]);

        $requeteFilm = $pdo->prepare("
        SELECT film.id_film AS id_film, titre
        FROM film
        WHERE film.id_realisateur = :id 
        ");
        $requeteFilm->execute(['id'=> $id]);

        $realisateur = $requeteReal->fetch();
        require "view/detailRealisateur.php";
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

        $genre = $requete->fetch();
        $films = $requeteFilms->fetchAll();
        require "view/detailGenre.php"; 
    }
    
// Affichage de la page Ajout Contenus
        public function ajouterContenu(){
            require "view/ajouterContenu.php";
        }

// Affichage de la page d'ajout film
    public function afficherAjoutFilm() {
        $pdo = Connect::seConnecter();
        $requeteGenre = $pdo->query("
        SELECT nom_genre, id_genre
        FROM genre 
        ");

        $requeteReal = $pdo->query("
        SELECT prenom, nom, id_realisateur AS id_realisateur
        FROM realisateur 
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        ");

        $requeteSelectFilm = $pdo->query("
        SELECT titre, film.id_film AS id_film
        FROM film 
        ");

        require "view/afficherAjoutFilm.php"; 
    }

// Affichage de la page d'ajout personne
    public function afficherAjoutPersonne(){
        require "view/afficherAjoutPersonne.php";
    }

// Affichage de la page d'ajout genre
    public function afficherAjoutGenre(){
        require "view/afficherAjoutGenre.php";
    }

// Affichage de la page UPDATE 
    public function afficherPageUpdate($id){
        $pdo = Connect::seConnecter();
        $requeteFilm = $pdo->prepare("
        SELECT titre, id_film, annee_sortie, duree
        FROM film
        WHERE id_film = :id
        ");
        $requeteFilm->execute(['id'=> $id]);

        $requeteActeur = $pdo->query("
        SELECT prenom, nom, id_acteur
        FROM acteur 
        INNER JOIN personne ON acteur.id_personne = personne.id_personne
        ");

        $requeteReal = $pdo->query("
        SELECT prenom, nom, id_realisateur
        FROM realisateur 
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        ");

        $requeteGenre = $pdo->query("
        SELECT nom_genre, id_genre
        FROM genre 
        ");
        $film = $requeteFilm->fetch();

        require "view/afficherPageUpdate.php";
    }


// ***************************************** FONCTIONS ******************************************************
// Supprimer un film 
public function supprimerFilm($id) {
    $pdo = Connect::seConnecter();
    $requeteDelete = $pdo->prepare("
    DELETE FROM film
    WHERE id_film = :id
    ");
    $requeteDelete->execute(['id'=> $id]);

    header('Location: index.php?action=listFilms');
    exit;
}

// Supprimer un réalisateur 
public function supprimerPerso($id) {
    $pdo = Connect::seConnecter();
    $requeteDelete = $pdo->prepare("
    DELETE FROM personne
    WHERE id_personne = :id
    ");
    $requeteDelete->execute(['id'=> $id]);

    header('Location: index.php?action=listPersonnes');
    exit;
}

// Ajouter un genre
    public function ajouterGenre(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        INSERT INTO genre (nom_genre)
        VALUES (:nom_genre) 
        ");
        $requete->execute([
            'nom_genre' => $_POST['nom_genre']
        ]);

        header('Location: index.php?action=ajouterContenu');
        exit;
    }

// Ajouter un film 
    public function ajouterFilm(){
        $pdo = Connect::seConnecter();
        $requeteAjoutFilm = $pdo->prepare("
        INSERT INTO film (titre, annee_sortie, id_realisateur, synopsis, duree, affiche_film, note)
        VALUES (:titre, :annee, :realisateur, :synopsis, :duree, :affiche, :note)
        ");
        $requeteAjoutFilm->execute([
            'titre' => $_POST['titre'],
            'annee' => $_POST['annee'],
            'realisateur' => $_POST['realisateur'],
            'synopsis' => $_POST['synopsis'],
            'duree' => $_POST['duree'],
            'affiche' => $_POST['affiche'],
            'note' => $_POST['note']
        ]);

        $idFilm = $pdo->lastInsertId();

        $requeteAjoutFilm_Genre = $pdo->prepare("
        INSERT INTO film_genre (id_film, id_genre)
        VALUES (:id_film, :genre)
        ");
        foreach ($_POST['genres'] as $idGenre){
            $requeteAjoutFilm_Genre->execute([
                'id_film' => $idFilm,
                'genre' => $idGenre
            ]);
        };

        header('Location: index.php?action=listFilms');
        exit;
    }

// Ajouter une personne
    public function ajouterPersonne(){
        $pdo = Connect::seConnecter();
        $requetePersonne = $pdo->prepare("
        INSERT INTO personne (nom, prenom, dateDeNaissance, sexe, photo)
        VALUES (:nom, :prenom, :dateNaissance, :sexe, :photo)
        ");

        $requetePersonne->execute([
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'dateNaissance' => $_POST['dateNaissance'],
        'sexe' => $_POST['sexe'],
        'photo' => $_POST['photo']
        ]);    

        $idPersonne = $pdo->lastInsertId();
        $requeteRealisateur = $pdo->prepare("
        INSERT INTO realisateur (id_realisateur, id_personne)
        VALUES (:id_real, :id_personne)
        ");

        $requeteRealisateur->execute([
            'id_real' => $POST_['id_real'],
            'id_personne' => $idPersonne
        ]);
    

        header('Location:index.php?action=ajouterContenu');
        exit;
    }
// Modifier un film 
    public function updateFilm(){
        $pdo = Connect::seConnecter();
        $requeteUpdateFilm = $pdo->prepare("
        UPDATE film 
        SET titre = :titre,
            synopsis = :synopsis,
            duree = :duree,
            note = :note,
            annee_sortie = :annee
            id_realisateur = :realisateur
        WHERE id_film = :id
        ");
        
        $requeteUpdateFilm->execute([
            'titre' => $_POST['titre'],
            'synopsis' => $_POST['synopsis'],
            'duree' => $_POST['duree'],
            'note' => $_POST['note'],
            'annee_sortie' => $_POST['annee'],
            'id_realisateur' => $_POST['realisateur'],
            'id_film' => $_POST['id_film']
        ]);

        var_dump($_POST); // Affiche tout le contenu de $_POST
        die(); 
        header('Location:index.php?action=listFilms');
        exit;
    }

}