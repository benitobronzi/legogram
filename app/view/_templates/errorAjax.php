<?php
/*
* Cette vue gère l'envoi d'un message d'erreur en réponse à un appel Ajax.
*/
if (http_response_code()==200) {
    http_response_code(500); // Internal Server Error
}
global $DEBUG,$DEBUGMSG; 
if ($DEBUG) { // mode DEBUG ?
    // on répond les messages de DEBUG
    if(count($DEBUGMSG)>0) {
        foreach($DEBUGMSG as $m) {
            print_r($m . "\n");
        }
    }    
}
die(); // s'assure que plus rien n'est fait ensuite, qu'il n'y aura plus rien dans la réponse ensuite

