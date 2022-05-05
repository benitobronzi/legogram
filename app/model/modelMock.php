<?php
class Model {

/*
*  Cette version de Model simule un comportement prédéfini de la DB.
*  Cette version est très utilie en développement pour pouvoir travailler en toute indépendance de la DB.
*  Elle est aussi utile pour forcer des cas particuliers qu'on peut souhaiter tester.
*/

    public function loadUser($name) {
        if ($name=="toto") {
            return array("name"=>"toto","login"=>"toto","id"=>42,"password"=>password_hash("toto",PASSWORD_BCRYPT));
        } else {
            return NULL;
        }
    }
    public function createUser($user) {
        return FALSE;
    }

    public function updateUser($user) {
        return TRUE;
    }

    public function listUsers() {
        return array(array("id"=>1,"name"=>"toto","login"=>"toto"));
    }
}