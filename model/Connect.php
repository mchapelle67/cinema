<?php 

// création namespace qui permet de catégoriser virtuellement ce qui permet de 'use' une class
// sans connaître son emplacement physique, juste en connaissant son namespace 

namespace Model;

// class abstraite car on instenciera jamais la class Connect puisqu'on aura seulement besoin d'accéder à la méthode 
//  "seConnecter"
abstract class Connect {

    const HOST = "localhost";
    const DB = "cinebdd";
    const USER = "root";
    const PASS = "";

    // connection SQL - utilisation d'un \ devant PDO: indique au framework que c'est une classe native et non une class du projet 
    public static function seConnecter() {
        try {
            return new \PDO(
                "mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASS);;
        } catch(\PDOException $ex) {
            return $ex->getMessage();
        }
    }
}