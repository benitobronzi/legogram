<?php
/*
*  Profile permet d'éditer son profil
*/
class Profile {

    private $model;

    // ce controlleur a besoin du modèle (de l'accès à la DB) pour fonctionner.
    // cette méthode sera appelée par index.php afin de le recevoir automatiquement.
    public function loadModel($model) {
        $this->model=$model;
    }

    /* fonction d'édition du profil
    *  Dans cet exemple, la modification du profil se fera par des appels Ajax à la Web 2.0.
    *  Cette fonction affiche donc juste la page d'édition.
    */
    public function edit() {
        require "../app/view/_templates/header.php";
        require "../app/view/_templates/menu.php";
        require "../app/view/profile.php";
        require "../app/view/_templates/footer.php";
    }

    /* fonction de modification du mot de passe
    *  Dans cet exemple, le mot de passe est changé via la soumission d'un formulaire par appel Ajax à la Web 2.0.
    *    - la réponse utilisera le code status HTTP pour notifier de la réussite ou l'échec
    *    - le message d'erreur sera envoyé sous forme textuelle, pas au format HTML.
    */
    public function newPassword() {
        // est-ce un appel Ajax de type POST ?
        if ($_SERVER["REQUEST_METHOD"]=="POST") { // oui
            $password1=$_POST["password1"]; // récupère les données du formulaire
            $password2=$_POST["password2"];
            $password3=$_POST["password3"];
            if($password2!=$password3) { // nouveaux mdp différents
                http_response_code(422); // 422=Unprocessable Entity
                echo "Les nouveaux mots de passe sont différents";
                return;
            }
            // pour valider l'ancier mdp, il faut relire l'utilisateur de la DB.
            $login=$_SESSION["login"]; // l'utilisateur connecté est dans la session
            $user=$this->model->loadUser($login); // le charge de la DB
            if (password_verify($password1,$user["password"])) { // valide l'ancien mdp
                // c'est bien le même => on peut le changer
                $user["password"]=password_hash($password2,PASSWORD_BCRYPT);
                if (!$this->model->updateUser($user)) {
                    http_response_code(422); // 422=Unprocessable Entity
                    echo "Erreur lors du changement de mot de passe";
                }
            } else {
                http_response_code(401); // 401=Unauthorized
                echo "Le mot de passe est invalide";
            }
        } else {
            http_response_code(404); // 404=Not Found
            require "../app/view/_templates/error.php";    
        }
    }

    public function newName() {
        // est-ce un appel Ajax de type POST ?
        if ($_SERVER["REQUEST_METHOD"]=="POST") { // oui
            $name=$_POST["name"]; // récupère les données du formulaire
            if (trim($name)!=$name) {
                http_response_code(422); // 422=Unprocessable Entity
                echo "Votre nom ne doit pas commencer ou finir par des espaces";
                return;
            } else if (strlen($name)<4) {
                http_response_code(422); // 422=Unprocessable Entity
                echo "Votre nom doit avoir au moins 4 caractères";
                return;
            }
            $login=$_SESSION["login"]; // l'utilisateur connecté est dans la session
            $user=$this->model->loadUser($login); // le charge de la DB
            $user["name"]=$name;
            if (!$this->model->updateUser($user)) {
                http_response_code(422); // 422=Unprocessable Entity
                echo "Erreur lors du changement de mot de passe";
            } else {
                $_SESSION["name"]=$name; // ne pas oublier de changer dans la session actuelle
            }
        } else {
            http_response_code(404); // 404=Not Found
            require "../app/view/_templates/error.php";    
        }
    }

}