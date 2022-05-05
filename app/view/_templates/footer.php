<?php
/* Cette vue est un fragment d'HTML gère le bas du document :
*    - Affiche une banière avec l'année et le nom de l'auteur.
*    - Insère les scripts de $js.
*    - Si le mode DEBUG est activé, alors les données de DEBUG sont aussi affichées.
*/
global $js, $author;
?>
</div>
<div class="footer">
    <div>&#x24B8; <?php echo date("Y") . " " . $author; ?> </div>
</div> </div>
<?php
array_unshift($js, "js/lib.js"); // charge lib.js tjs en tête
foreach ($js as $f) { // insère les références aux fichiers js
    echo "<script src=\"$f\"></script>\n";
}

global $DEBUG, $DEBUGMSG;

if ($DEBUG) { // si le debug est activé, affiche des informations supplémentaires
    echo "<pre class=\"debug\">";
    echo '$_REQUEST<hr>';
    var_dump($_REQUEST);
    echo "<hr>";
    if (isset($_SESSION)) {
        echo '$_SESSION<hr>';
        var_dump($_SESSION);
    }
    if (count($DEBUGMSG) > 0) {
        echo '$DEBUGMSG<hr>';
        foreach ($DEBUGMSG as $m) {
            print_r($m . "\n");
        }
    }
    echo "</pre>";
}
?>
</body>

</html>