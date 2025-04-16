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
        case "detailActeur": $ctrlCinema->detailActeur($id); break; 
        case "listReal": $ctrlCinema->listReal($id); break;
        case "detailFilm": $ctrlCinema->detailFilm($id); break;
    }
}


