<?php
/*
*  Model se charge de la DB :
*     - open() fonction privée qui ouvre la connexion à la DB quand c'est nécessaire.
*              Les autres fonctions appèleront toujours d'abord open().
*     - loadUser($login) : retourne l'utilisateur dont le login est $login ou NULL s'il n'existe pas.
*     - createUser($user) : crée cet utilisateur dans la DB.
*     - changePassword($login,$password) : change le mdp de $login à $password.
*     - deleteUser($login) : supprime l'utilisateur $login de la DB.
*/
class Model {
    private $pdo=NULL;

    /* ouvre la connexion à la DB
    * doit être appelée avec l'utilisation de $this->pdo.
    * peut être appelée plusieurs fois d'affilée, la connexion n'est ouverte que la première fois.
    */
    private function open() {
        if ($this->pdo==NULL) { // n'ouvrir la connexion que si elle ne l'est pas déjà.
            global $host, $db, $charset, $user, $pass; 
            $dsn="mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->pdo=new PDO($dsn, $user, $pass, $options);    
        }
    }

    /* charge un utilisateur de la DB
    * renvoie un tableau associatif contenant cet utilisateur ou bien NULL s'il n'existe pas. 
    */
    public function loadUser($login) {
        $this->open();
        $stmt=$this->pdo->prepare("SELECT * FROM users WHERE login=:login");
        $stmt->execute(array(":login"=>$login));
        if ($row=$stmt->fetch()) {
            return $row;
        } else {
            return NULL;
        }
    }

    /* crée un utilisateur dans la DB
    * renvoie vrai si cela a fonctionné, faux au sinon. 
    */
    public function createUser($user) {
        $this->open();
        $stmt=$this->pdo->prepare("INSERT INTO users (login,name,password) VALUES (:login,:name,:password)");
        return $stmt->execute(array(":login"=>$user["login"],":name"=>$user["name"],":password"=>$user["password"]));
    }

    /* change le mdp d'un utilisateur dans la DB
    * renvoie vrai si cela a fonctionné, faux au sinon. 
    */
    public function updateUser($user) {
        $this->open();
        $stmt=$this->pdo->prepare("UPDATE users SET password=:password, name=:name WHERE login=:login");
        return $stmt->execute(array(":login"=>$user["login"],":name"=>$user["name"],":password"=>$user["password"]));
    }

    /* efface un utilisateur de la DB
    * renvoie vrai si cela a fonctionné, faux au sinon. 
    * NB : cette fonction n'est pas appelée actuellement dans le code. Elle illustre la manière d'effacer dans la DB.
    */
    public function deleteUser($login) {
        $this->open();
        $stmt=$this->pdo->prepare("DELETE FROM users WHERE login=:login");
        return $stmt->execute(array(":login"=>$login));
    }

    public function listUsers() {
        $this->open();
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
        //alternative :
        //return $users=json_decode(file_get_contents('.../app/files/users.json'),true);
        //Dans le cas où on utiliserait un fichier json comme bd 
    }

}
