<?php
/*
*  Home affiche la page d'accueil. Il y en a en fait deux versions suivant que l'utilisateur est connecté ou pas.
*/
class Home {
    public function index() {
        require "../app/view/_templates/header.php";
        require "../app/view/home.php";
        require "../app/view/_templates/footer.php";
    }
    public function nosession() {
        require "../app/view/_templates/header.php";
        require "../app/view/nosession.php";
        require "../app/view/_templates/footer.php";
    }
}