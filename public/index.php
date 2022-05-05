<?php
/*
* index.php est ce qu'on appelle un Front Controller.
* *toutes* les requêtes sont envoyées ici, Ajax y compris !
*
* index.php gèrera deux paramètres explicitement :
*   - c qui désignera un controlleur = une classe définie par un fichier dans le répertoire model
*   - a qui désignera une action = une méthode de cette classe
*
* Quand l'utilisateur arrive sur cette page la première fois, il n'y aura pas de paramètre.
* On considérera alors automatiquement c=home&a=nosession si l'utilisateur n'est pas authentifié, c=home&a=index sinon
*/ 
require "../app/config/config.php";

session_start(); // sans session, pas de $_SESSION

// l'utilisateur est-il authentifié ? Ou bien, est-ce qu'il essaie de s'authentifier/s'enregistrer ?
if (isset($_SESSION["login"]) || (isset($_GET["c"]) && $_GET["c"]=="auth") ) { // oui
    // gère l'absence/présence des paramètres c et a
    if (isset($_GET["c"])) { // paramètre c est présent
        $c=$_GET["c"];
        if (!isset($_GET["a"])) { // paramètre a aussi présent
            http_response_code(400); // 400=Bad Request
            array_push($DEBUGMSG,"manque l'action");
            require "../app/view/_templates/error.php";
        } 
        $a=$_GET["a"];
    } else { // si aucun controlleur (index.php tout court), alors on affiche la homepage par défaut
        $c="home";
        $a="index";
    }
} else {  // pas authentifié, alors on affiche la homepage sans session
    $c="home";
    $a="nosession";
}

/* sur base de la valeur de $c, il faut instancier le bon controlleur.
*  on le trouvera dans le répertoire app/controller
*  son nom sera $c.php
*  la classe à instancier est $c où la première lettre est mise en majuscule
*/
$controller=NULL;
try {
    require "../app/controller/$c.php"; // require le bon controlleur
    $c=strtoupper(substr($c,0,1)) . substr($c,1); // première lettre en majuscule
    $controller=new $c(); // instancie le controlleur
} catch (Throwable $e) { // il n'a pas été possible d'instancier ce controlleur correctement
    http_response_code(400); // 400=Bad Request
    array_push($DEBUGMSG,"". $e);
    require "../app/view/_templates/error.php";
}

/* le controlleur a-t-il besoin du modèle ?
*  Ceci est décidé par une simple convention : la présence d'une function s'appelant loadModel
*/
if (method_exists($controller,"loadModel")) { // oui
    $model=createModel(); // instanciation du modèle ; la fonction createModel est définie dans config.php
    $controller->loadModel($model); // on donne le modèle au controlleur ; ceci s'appelle de l'injection.
}

/* est-ce que l'action existe ?
*  C'est déterminé par l'existe d'une function du même nom dans le controller.
*  Il y a une exception : une action ne peut pas s'appeler loadModel puisque c'est utilisé pour le chargement du modèle.
*/
if ($a!="loadModel" && method_exists($controller,$a)) { 
    try {
        $controller->{$a}(); // appelle la fonction d'action
    } catch (Throwable $e) { 
        // normalement il ne devrait pas y avoir d'exception, cependant si c'est le cas :
        array_push($DEBUGMSG,"Exception: " . $e);
        require "../app/view/_templates/error.php";
    }
} else {
    http_response_code(400); // 400=Bad Request
    array_push($DEBUGMSG,"action inconnue");
    require "../app/view/_templates/error.php";
}
