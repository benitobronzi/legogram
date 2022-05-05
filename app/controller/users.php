<?php
class Users {

    private $model;

    // ce controlleur a besoin du modèle (de l'accès à la DB) pour fonctionner.
    // cette méthode sera appelée par index.php afin de le recevoir automatiquement.
    public function loadModel($model) {
        $this->model=$model;
    }

    /*public function view() {

        require "../app/view/_templates/header.php";
        require "../app/view/_templates/menu.php";
        require "../app/view/users.php";
        require "../app/view/_templates/footer.php";
    }*/

    public function view() {
        global $users; //Pour voir les utilisateurs, on s'adresse au modèle et on créé une variable qu'on appel allUsers
        $users=$this->model->listUsers(); //Et on dit que la variable global users c'est le résultat de l'appel d'une fonction 
        // Elle va renvoyer la liste de tous les utilisateurs. 
        // Elle ne peut pas fonctionner seul, on doit la définir dans model. 
        require "../app/view/_templates/header.php";
        require "../app/view/listUsers.php";
        require "../app/view/_templates/footer.php";
    }

    public function deleteUser() {
        $login=$_POST["login"];
        if ($this->model->deleteUser($login)) {
            echo "ok";
        } else {
            http_response_code(400);
            echo "Erreur lors de l'effacement de l'utilisateur";
        }
    }

}