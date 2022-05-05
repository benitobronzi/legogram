<?php
/* Cette vue est un fragment d'HTML qui gère une fenêtre popup :
*     - Cette fenêtre permettra à l'utilisateur de s'authentifier.
*     - C'est auth.js qui gère cette fenêtre, via Javascript.
*/
global $js;
array_push($js, "js/auth.js");
?>
<div class="loginbox">
    <div class="hider"></div>
    <form>
        <input type="submit" value="x" class="cancel">
        <div class="boxtitle">
            Connexion
        </div>
        <hr>
        <h2>
            Bienvenue sur Legogram
        </h2>
        <div class="loginboxtop">
            <div>
                <input type="text" name="login" id="inputlogin" placeholder="Authentifiant">
            </div>
            <div>
                <input type="password" name="password" id="inputpassword" placeholder="Mot de passe">
            </div>
            <div class="error">
            </div>
        </div>
        <input type="submit" value="Se connecter" class="roundedButton">
    </form>
</div>