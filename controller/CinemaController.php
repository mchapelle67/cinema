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
        $realisateur = $requeteReal->fetch();

        if(isset($realisateur['id_film'])) {
        $requeteFilm = $pdo->prepare("
            SELECT film.id_film AS id_film, titre
            FROM film
            WHERE film.id_realisateur = :id 
            ");
        $requeteFilm->execute(['id'=> $id]);
         } else {
            echo "Filmographie non repertoriée";

        };
        
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
    
// Affichage de la page d'ajouts de contenus
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
        SELECT titre, annee_sortie, duree, id_film
        FROM film
        WHERE id_film = :id
        ");
        $requeteFilm->execute(['id'=> $id]);

        $requeteReal = $pdo->query("
        SELECT prenom, nom, id_realisateur
        FROM realisateur 
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        ");

        $requeteGenre = $pdo->query("
        SELECT nom_genre, id_genre
        FROM genre 
        ");

        $requeteFilmGenre = $pdo->query("
        SELECT id_film, id_genre 
        FROM film_genre
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
        $genre = filter_input(INPUT_POST, 'nom_genre', FILTER_SANITIZE_SPECIAL_CHARS);

        $requete = $pdo->prepare("
        INSERT INTO genre (nom_genre)
        VALUES (:nom_genre) 
        ");
        $requete->execute([
            'nom_genre' => $genre
        ]);

        header('Location: index.php?action=ajouterContenu');
        exit;
    }

// Ajouter un film 
    public function ajouterFilm(){
        $pdo = Connect::seConnecter();

        $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
        $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_SPECIAL_CHARS);
        $affiche = filter_input(INPUT_POST, 'affiche', FILTER_SANITIZE_SPECIAL_CHARS);

        $requeteAjoutFilm = $pdo->prepare("
        INSERT INTO film (titre, annee_sortie, id_realisateur, synopsis, duree, affiche_film, note)
        VALUES (:titre, :annee, :realisateur, :synopsis, :duree, :affiche, :note)
        ");
        

        $requeteAjoutFilm->execute([
            'titre' => $titre,
            'annee' => $_POST['annee'],
            'realisateur' => $_POST['realisateur'],
            'synopsis' => $synopsis,
            'duree' => $_POST['duree'],
            'affiche' => $affiche,
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
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
        $photo = filter_input(INPUT_POST, 'photo', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $requetePersonne = $pdo->prepare("
        INSERT INTO personne (nom, prenom, dateDeNaissance, sexe, photo)
        VALUES (:nom, :prenom, :dateNaissance, :sexe, :photo)
        ");

        $requetePersonne->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'dateNaissance' => $_POST['dateNaissance'],
        'sexe' => $_POST['sexe'],
        'photo' => $photo
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
    public function updateFilm($id){
        $pdo = Connect::seConnecter();
        $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
        $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_SPECIAL_CHARS);
    

        $requeteUpdateFilm = $pdo->prepare("
        UPDATE film 
        SET titre = :titre,
            synopsis = :synopsis,
            duree = :duree,
            note = :note,
            annee_sortie = :annee,
            id_realisateur = :realisateur
        WHERE id_film = :id
        ");

        $requeteUpdateFilm->execute([
            'titre' => $titre,
            'synopsis' => $synopsis,
            'duree' => $_POST['duree'],
            'note' => $_POST['note'],
            'annee' => $_POST['annee'],
            'realisateur' => $_POST['realisateur'],
            'id' => $id
        ]);
        
        $requeteDeleteGenre = $pdo->prepare("
        DELETE FROM film_genre
        WHERE id_film = :id
        ");
        $requeteDeleteGenre->execute(['id' => $id]);

        foreach ($_POST['genres'] as $idGenre){
            $requeteUpdateGenre = $pdo->prepare("
                INSERT INTO film_genre (id_film, id_genre)
                VALUES (:id_film, :id_genre)
                ");
            $requeteUpdateGenre->execute([
                'id_film' => $id,
                'id_genre' => $idGenre
            ]);
        };

        header('Location:index.php?action=listFilms');
        exit;
    }
}

// public function editMovie($id)
    // {
    //     if (!Service::exists("movie", $id)) {
    //         header("Location:index.php");
    //         exit;
    //     } else {
    //         $session = new Session();
    //         if ($session->isAdmin()) {
    //             $pdo = Connect::toLogIn();

    //             $requestMovie = $pdo->prepare("
    //     SELECT movie.idMovie, movie.title, movie.releaseYear, movie.duration, movie.note, movie.synopsis, movie.poster, movie.idDirector
    //     FROM movie
    //     WHERE movie.idMovie = :id
    //     ");
    //             $requestMovie->execute(["id" => $id]);

    //             $requestDirectors = $pdo->query("
    //     SELECT director.idDirector, person.firstname, person.surname
    //     FROM director
    //     INNER JOIN person ON director.idPerson = person.idPerson
    //     ORDER BY surname
    //     ");

    //             $requestThemes = $pdo->query("
    //     SELECT theme.idTheme, theme.typeName
    //     FROM theme
    //     ORDER BY typeName
    //     ");

    //             $requestMovieThemes = $pdo->prepare("
    //     SELECT theme.idTheme
    //     FROM movie_theme
    //     INNER JOIN theme ON movie_theme.idTheme = theme.idTheme
    //     INNER JOIN movie ON movie_theme.idMovie = movie.idMovie
    //     WHERE movie.idMovie = :id
    //     ");
    //             $requestMovieThemes->execute(["id" => $id]);

    //             $themes = $requestMovieThemes->fetchAll();
    //             $themesMovie = [];
    //             foreach ($themes as $t) {
    //                 $themesMovie[] = $t["idTheme"];
    //             }

    //             if (isset($_POST['submit'])) {

    //                 $newTitle = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //                 $newReleaseYear = filter_input(INPUT_POST, "releaseYear", FILTER_VALIDATE_INT);
    //                 $newDuration = filter_input(INPUT_POST, "duration", FILTER_VALIDATE_INT);
    //                 $newNote = filter_input(INPUT_POST, "note", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //                 $newSynopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //                 $newDirector = filter_input(INPUT_POST, "idDirector", FILTER_SANITIZE_NUMBER_INT);

    //                 if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    //                     $tmpName = $_FILES['file']['tmp_name'];
    //                     $name = $_FILES['file']['name'];
    //                     $size = $_FILES['file']['size'];
    //                     $error = $_FILES['file']['error'];
    //                     $type = $_FILES['file']['type'];

    //                     $tabExtension = explode('.', $name);
    //                     $extension = strtolower(end($tabExtension));

    //                     // Tableau des extensions qu'on autorise
    //                     $allowedExtensions = ['jpg', 'png', 'jpeg', 'webp'];
    //                     $maxSize = 100000000;

    //                     if (in_array($extension, $allowedExtensions) && $size <= $maxSize && $error == 0) {

    //                         $uniqueName = uniqid('', true);
    //                         $file = $uniqueName . '.' . $extension;

    //                         $requestPoster = $pdo->prepare("
    //                     SELECT movie.poster
    //                     FROM movie
    //                     WHERE movie.idMovie = :id
    //                     ");
    //                         $requestPoster->execute(["id" => $id]);

    //                         // Permet de récupérer l'image du poster du film et de la supprimer en passant par la variable et le tableau "poster", autrement on pourrait faire une variable pour récupérer directement le tableau
    //                         $linkPoster = $requestPoster->fetch();

    //                         if (!$linkPoster !== "./public/img/movies/default.webp") {
    //                             unlink($linkPoster['poster']);
    //                         }

    //                         // On récupère l'image de notre forumulaire via la superglobale file, on prend le chemin et on crée l'image
    //                         $posterSource = imagecreatefromstring(file_get_contents($tmpName));
    //                         // Récupération du chemin cible de l'image
    //                         $webpPath = "public/img/movies/" . $uniqueName . ".webp";
    //                         // Conversion en format webp (on prend l'image et on la colle dans le dossier de destination)
    //                         imagewebp($posterSource, $webpPath);

    //                         $requestNewPoster = $pdo->prepare("
    //                     UPDATE movie
    //                     SET poster = :poster
    //                     WHERE idMovie = :id
    //                     ");

    //                         $requestNewPoster->execute([
    //                             "poster" => $webpPath,
    //                             "id" => $id
    //                         ]);
    //                     } else {
    //                         echo "Wrong extension or file size too large or error !";
    //                         exit;
    //                     }
    //                 }

    //                 $requestEditMovie = $pdo->prepare("
    //             UPDATE movie
    //             SET title = :title, releaseYear = :releaseYear, duration = :duration, note = :note, synopsis = :synopsis, idDirector = :idDirector
    //             WHERE idMovie = :id
    //             ");
    //                 $requestEditMovie->execute([
    //                     "title" => $newTitle,
    //                     "releaseYear" => $newReleaseYear,
    //                     "duration" => $newDuration,
    //                     "note" => $newNote,
    //                     "synopsis" => $newSynopsis,
    //                     "idDirector" => $newDirector,
    //                     "id" => $id
    //                 ]);

    //                 $theme = filter_input(INPUT_POST, "idTheme", FILTER_VALIDATE_INT);

    //                 $requestPurgeMovieTheme = $pdo->prepare("
    //             DELETE FROM movie_theme
    //             WHERE idMovie = :idMovie
    //             ");

    //                 $requestPurgeMovieTheme->execute([
    //                     "idMovie" => $id
    //                 ]);

    //                 foreach ($_POST['theme'] as $theme) {

    //                     $requestEditMovieTheme = $pdo->prepare("
    //             INSERT INTO movie_theme (idMovie, idTheme)
    //             VALUES(:idMovie, :idTheme)
    //             ");

    //                     $requestEditMovieTheme->execute([
    //                         "idMovie" => $id,
    //                         "idTheme" => $theme
    //                     ]);
    //                 }

    //                 header("Location:index.php?action=editMovie&id=$id");
    //                 $_SESSION['message'] = "<div class='alert'>This movie has been edited successfully !</div>";
    //                 exit;
    //             }

    //             require "view/movies/editMovie.php";
    //         } else {
    //             header("Location:index.php");
    //             exit;
    //         }
    //     }
    // }