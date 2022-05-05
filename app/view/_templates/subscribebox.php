<?php
/* Cette vue est un fragment d'HTML qui gère une fenêtre popup :
*     - Cette fenêtre permettra à l'utilisateur de s'authentifier.
*     - C'est auth.js qui gère cette fenêtre, via Javascript.
*/
global $js;
array_push($js, "js/subscribe.js");
?>

<?php
global $name, $login, $password1, $password2, $error;
?>

<div class="subscribebox">
    <div class="hider"></div>
    <form method="POST" action="index.php?c=auth&a=subscribe">
    <button class="cancel"><a href="index.php">x</a></button>
        <div class="boxtitle">
            Inscription
        </div>
        <hr>
        <h2>
            Bienvenue sur Legogram
        </h2>
        <div class="subscribeboxtop">
            <div>
                <input type="text" id="login" name="login" placeholder="Identifiant" value="<?php if (isset($login)) echo htmlspecialchars($login); ?>">
            </div>
            <div>
                <input type="text" id="name" name="name" placeholder="Votre nom" value="<?php if (isset($name)) echo htmlspecialchars($name); ?>">
            </div>
            <div>
                <input type="password" id="password1" name="password1" placeholder="Votre mot de passe" value="<?php if (isset($password1)) echo htmlspecialchars($password1); ?>">
            </div>
            <div>
                <input type="password" id="password2" name="password2" placeholder="Recopiez votre mot de passe" value="<?php if (isset($password2)) echo htmlspecialchars($password2); ?>">
            </div>
            <div>
                <?php if (isset($error)) {
                    echo "<div colspan=\"2\" class=\"error\">$error</div>";
                }
                ?>
            </div>
        </div>
        <input type="submit" value="S'inscrire" class="roundedButton">
    </form>
</div>