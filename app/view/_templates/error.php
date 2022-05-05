<?php
/*
* Cette vue affiche une page d'erreur. 
*/
if (http_response_code()==200) {
    http_response_code(500); // Internal Server Error
}
/* il n'est pas possible de distinguer les requêtes Ajax des autres requêtes
*  En Ajax, on souhaiterait renvoyer un texte simple, tandis que pour les autres requêtes, il faut renvoyer de l'HTML.
*  En compromis, cette page d'erreur va renvoyer le texte simple en haut du document, sous forme de commentaire HTML.
*/
echo "<!--";
global $DEBUG,$DEBUGMSG; 
if ($DEBUG) { // mode DEBUG ?
    // on répond les messages de DEBUG
    if(count($DEBUGMSG)>0) {
        foreach($DEBUGMSG as $m) {
            print_r($m . "\n");
        }
    }
    echo "\n\n";
}
echo "-->";
require 'header.php';
?>
Désolé, mais il y a eu une erreur...
<?php
require 'footer.php';
die(); // s'assure que plus rien n'est fait ensuite, qu'il n'y aura plus rien dans la réponse ensuite

