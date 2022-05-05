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

    public function addphoto()
    {
        $uploaddir = '/img';
        $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

        echo '<pre>';
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            echo "Le fichier est valide, et a été téléchargé
           avec succès. Voici plus d'informations :\n";
        } else {
            echo "Attaque potentielle par téléchargement de fichiers.
          Voici plus d'informations :\n";
        }

        echo 'Voici quelques informations de débogage :';
        print_r($_FILES);

        echo '</pre>';
    }
}
