<?php
/*
*  Auth se charge de gérer l'authentification :
*    - login : s'authentifier
*    - logout : se déconnecter
*    - subscribe : s'enregistrer
*/
class Auth {

    private $model;

    // ce controlleur a besoin du modèle (de l'accès à la DB) pour fonctionner.
    // cette méthode sera appelée par index.php afin de le recevoir automatiquement.
    public function loadModel($model) {
        $this->model=$model;
    }

    /* fonction d'authentification
    *  Dans cet exemple, le login est géré par un popup et un appel Ajax qui soumet le formulaire à la Web 2.0 :
    *    - la réponse utilisera le code status HTTP pour notifier de la réussite ou l'échec
    *    - le message d'erreur sera envoyé sous forme textuelle, pas au format HTML.
    */
    public function login() {
        // est-ce un appel Ajax de type POST ?
        if ($_SERVER["REQUEST_METHOD"]=="POST") { // oui
            // récupère le login et le mdp
            $login=$_POST["login"];
            $password=$_POST["password"];
            // charge l'utilisateur possédant ce login
            $user=$this->model->loadUser($login);
            // valide qu'on l'a trouvé et que le mdp est correct
            if ($user!=NULL && password_verify($password,$user["password"])) {
                // enregistre ce login dans la session : il est maintenant connecté
                $_SESSION["login"]=$user["login"];
                $_SESSION["name"]=$user["name"];
            } else {
                // gestion de l'erreur via un code status HTTP et un message d'erreur
                http_response_code(401); // 401=Unauthorized
                echo "Utilisateur inconnu 
                et/ou mot de passe incorrect";
            }
        } else {
            http_response_code(404); // Not Found
            require "../app/view/_templates/error.php";    
        }
    }

    // fonction de déconnexion
    public function logout() {
        session_unset();
        session_destroy();
        // redirection vers la page index.php
        header("Location: index.php");
    }

    /* fonction de souscription
    *  Dans cet exemple, la souscription est gérée par la soumission d'un formulaire à la Web 1.0 :
    *    - la réponse sera une page HTML complète.
    *    - la même action est utilisée pour afficher le formulaire et pour sa soumission.
    *    - le controlleur utilise des variables globales pour donner l'information dont la vue à besoin pour s'afficher.
    */
    public function subscribe() {
        // est-ce qu'on soumet le formulaire ?
        if ($_SERVER["REQUEST_METHOD"]=="POST") { // oui
            // ces variables serviront dans la vue.
            global $name, $login, $password1, $password2, $error;
            $error=NULL; // NULL représente l'absence d'erreur
            $name=$_POST["name"]; // récupère les données soumises
            $login=$_POST["login"]; // récupère les données soumises
            $password1=$_POST["password1"];
            $password2=$_POST["password2"];
            // validation de ces données
            if (trim($password1)!=$password1) {
                $error="Le mot de passe ne doit pas commencer ou finir par des espaces";
            } else if ($password1!=$password2) {
                $error="Les mots de passe sont différents";
            } else if (trim($login)!=$login) {
                $error="L'identifiant ne doit pas commencer ou finir par des espaces";
            } else if (strlen($login)<4) {
                $error="L'identifiant doit avoir au moins 4 caractères";
            } else if (trim($name)!=$name) {
                $error="Votre nom ne doit pas commencer ou finir par des espaces";
            } else if (strlen($name)<4) {
                $error="Votre nom doit avoir au moins 4 caractères";
            } else if (strlen($password1)<4) {
                $error="Le mot de passe doit avoir au moins 4 caractères";
            } else {
                // les données sont considérées valides, on va tenter de créer l'utilisateur
                // est-ce qu'un utilisateur existe déjà en DB avec ce login ?
                $user=$this->model->loadUser($login);                
                if ($user!==NULL) {
                    $error="Cet identifiant n'est pas disponible";
                } else {
                    // crée l'utilisateur dans la DB
                    $this->model->createUser(array("name"=>$name,"login"=>$login,"password"=>password_hash($password1,PASSWORD_BCRYPT)));
                    // auto login de cet utilisateur
                    $_SESSION["name"]=$name;
                    $_SESSION["login"]=$login;
                }
            }
            if ($error==NULL) {
                // il n'y a toujours pas d'erreur à ce stade :
                //    - l'utilisateur a été créé
                //    - il est connecté
                // => on peut redigirer vers index.php
                header('location: index.php');
            } else {
                // s'il y a des erreurs, il faut juste réafficher le formulaire, la vue affichera les détails
                require "../app/view/_templates/header.php";
                require "../app/view/subscribe.php";
                require "../app/view/_templates/footer.php";        
            }
        } else { // on affiche juste le formulaire
            require "../app/view/_templates/header.php";
            require "../app/view/subscribe.php";
            require "../app/view/_templates/footer.php";    
        }
    }

}