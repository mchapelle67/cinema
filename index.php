<?php 

// design pattern: controller-frontend 

// on connecte au controller 
use Controller\CinemaController;

// on autocharge les classes du projet 
spl_autoload_register(function ($class_name) {
    include $class_name.'.php';
});

// on instancie le controller Cinema 
$ctrlCinema = new CinemaController();

$id = (isset($_GET['id'])) ? $_GET['id'] : null;

// en fonction de l'action détéctée dans l'URL via 'action' on interagit avec la bonne méthode du controller
if(isset($_GET["action"])){
    switch($_GET["action"]) {

        case "listFilms": $ctrlCinema->listFilms(); break;
        case "listPersonnes": $ctrlCinema->listPersonnes(); break;
        case "listGenre": $ctrlCinema->listGenres(); break;
        case "detailActeur": $ctrlCinema->detailActeur($id); break; 
        case "detailFilm": $ctrlCinema->detailFilm($id); break;
        case "detailRealisateur": $ctrlCinema->detailRealisateur($id); break;
        case "detailGenre": $ctrlCinema->detailGenre($id); break;
        case "ajouterContenu": $ctrlCinema->ajouterContenu(); break;
        case "afficherAjoutFilm": $ctrlCinema->afficherAjoutFilm(); break;
        case "ajouterFilm": $ctrlCinema->ajouterFilm(); break;
        case "afficherAjoutPersonne": $ctrlCinema->afficherAjoutPersonne(); break;
        case "ajouterPersonne": $ctrlCinema->ajouterPersonne(); break;
        case "supprFilm": $ctrlCinema->supprimerFilm($id); break;
        case "afficherAjoutGenre": $ctrlCinema->afficherAjoutGenre(); break;
        case "ajouterGenre": $ctrlCinema->ajouterGenre(); break;
        case "afficherPageUpdate": $ctrlCinema->afficherPageUpdate($id); break;
        case "updateFilm": $ctrlCinema->updateFilm($id); break;
    }
}
