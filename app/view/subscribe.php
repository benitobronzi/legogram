<?php
global $name, $login, $password1, $password2, $error;
?>
<div class="subscribe">
<br>
<h1>Bienvenue sur notre site.</h1> <br> 
<br>
<h4>Formulaire d'inscription</h4>
<div>
<form method="POST" action="index.php?c=auth&a=subscribe">
<table>
    <tbody>
        <tr>
            <td><label for="login">Identifiant : </label></td><td><input type="text" id="login" name="login" value="<?php if (isset($login)) echo htmlspecialchars($login);?>"></td>
        </tr><tr>
            <td><label for="name">Votre nom : </label></td><td><input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($name);?>"></td>
        </tr><tr>
            <td><label for="password1">Mot de passe :</label></td><td><input type="password" id="password1" name="password1" value="<?php if (isset($password1)) echo htmlspecialchars($password1);?>"></td>
        </tr><tr>
            <td><label for="password2">Mot de passe répété :</label></td><td><input type="password" id="password2" name="password2" value="<?php if (isset($password2)) echo htmlspecialchars($password2);?>"></td>
        </tr>
        <?php if (isset($error)) {
            echo "<tr><td colspan=\"2\" class=\"error\">$error</td></tr>";
        }
        ?>
        <tr>
            <td colspan="2">
                <a href="index.php" class="roundedButton">Annuler</a>
                <input type="submit" value="Ok" class="roundedButton">
            </td>
        </tr>
    </tbody>
</table>
</form>
</div>
</div>

<?php require "../app/view/_templates/loginbox.php"; ?>