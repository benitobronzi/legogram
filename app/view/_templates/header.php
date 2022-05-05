<?php
/* Cette vue est un fragment d'HTML gère le haut du document :
*    - Affiche une banière avec un logo, titre et les boutons gérant la connexion.
*    - Insère les feuilles de style.
*/
global $css, $title;
array_unshift($css, "css/style.css"); // place toujours cette feuille en tête
?>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <title><?php echo $title; ?></title>
    <?php // insère toutes les feuilles de style
    foreach ($css as $f) {
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$f\">\n";
    }
    ?>
</head>

<body>
    <div class="header">
        <div class="top-topbar">
            <span>
                <?php
                if (isset($_SESSION["name"])) { // suivant qu'on est loggé ou pas
                    // on peut se délogger
                    echo '<a href="index.php?c=auth&a=logout">Se déconnecter de ' . $_SESSION["name"] . "</a>";
                } else {
                    // on peut s'inscrire ou se logger
                    echo '<a href="#" id="login">S\'authentifier</a><a href="#" id="subscribe">S\'inscrire</a>';
                } // index.php?c=auth&a=subscribe
                ?>
            </span>
        </div>
        <div class="topbar">
            <div>
                <a href="index.php" class="logolink"><img src="img/logo.png"></a>
            </div>
            <?php
            global $js;
            array_push($js, "js/menu.js"); // ce fichier js se chargera de faire ressortir le menu actif en fonction de l'URL de la page
            ?>
            <div class="menu">
                <?php
                if (isset($_SESSION["name"])) { // suivant qu'on est loggé ou pas
                    // on peut se délogger
                    echo
                    "<div><a href='index.php'>Accueil</a></div> 
            <div><a href='index.php?c=profile&a=edit'>Mon profil</a></div> 
            <div><a href='index.php?c=users&a=view'>Liste des utilisateurs</a></div>
            <div><a href='index.php?c=addphoto&a=view'>Ajouter une photo</a></div>";
                } else {
                    echo "<div><a href='index.php'>Accueil</a></div>";
                    echo "<div><a href='index.php#about'>A propos</a></div>";
                }
                ?>
            </div>
        </div>
    </div>