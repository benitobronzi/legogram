<?php
// les données de configuration
$DEBUG=TRUE;               // activation/désactivation de l'affichage DEBUG
$DEBUGMSG=array();          // tableau qu'on peut remplir de messages de DEBUG
$css=array();               // tableau qu'on peut remplir de feuilles CSS
$js=array();                // tableau qu'on peut remplir de scripts JS
$title="Legogram";        // titre du site
$author="Benito"; // nom de l'auteur

// données de connexion à la DB
$host="127.0.0.1";
$db="test";
$user="root";
$pass="";
$charset="utf8mb4";

// cette fonction crée un modèle. 
// Elle est dans le fichier config de manière à pouvoir changer facilement la classe du modèle.
// En particulier, nous aurons deux versions : 
//   - model.php travaille avec la vraie DB, à utiliser en production ;
//   - modelMock.php ne se connecte pas à la DB, mais simule un comportement prédéfini.
function createModel() {
    static $model=NULL;
    if ($model==NULL) {
        require "../app/model/model.php"; // choisir entre model.php et modelMock.php
        $model=new Model();
    }
    return $model;
}

$upload="C:/xampp/htdocs/legogram";
$uploadURL="legogram/public/upload";
