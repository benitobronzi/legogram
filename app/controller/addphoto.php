<?php
class Addphoto
{

    private $model;

    // ce controlleur a besoin du modèle (de l'accès à la DB) pour fonctionner.
    // cette méthode sera appelée par index.php afin de le recevoir automatiquement.
    public function loadModel($model)
    {
        $this->model = $model;
    }

    public function view()
    {
        global $users; //Pour voir les utilisateurs, on s'adresse au modèle et on créé une variable qu'on appel allUsers
        $users = $this->model->listUsers(); //Et on dit que la variable global users c'est le résultat de l'appel d'une fonction 
        // Elle va renvoyer la liste de tous les utilisateurs. 
        // Elle ne peut pas fonctionner seul, on doit la définir dans model. 
        require "../app/view/_templates/header.php";
        require "../app/view/addphoto.php";
        require "../app/view/_templates/footer.php";
    }

    public function add()
    {
        $file = $_FILES["image"];
        if (!(isset($file))) {
            $error = "Fichier manquant";
        } else if ($file["size"] == 0) {
            $error = "Fichier vide ou trop grand (max 3MB)";
        } else if ($file["error"] != 0) {
            $error = "Problème lors de l'envoi du fichier";
        } else {
            // chaque utilisateur possède son propre répertoire d’upload
            $uploadfile = $GLOBALS["upload"] . "/" . $_SESSION["login"];
            echo $uploadfile . "<br>";
            if (!file_exists($uploadfile)) {
                mkdir($uploadfile, 0777, true);
            }
            $filename = "/" . $file["name"];
            $uploadfile = $uploadfile . $filename;
            echo $uploadfile  . "<br>";
            echo $file['tmp_name']  . "<br>";
            print_r($_FILES);
            print_r($_REQUEST);
            move_uploaded_file($file['tmp_name'], $uploadfile);
            /*$this->model->createItem(
                array("path" => $GLOBALS["uploadURL"] . "/" . $_SESSION["login"] . $filename)
            );*/
        }
    }
}
