<div class="center">
    <div class="welcome profile">
        <h4>Changement du mot de passe</h4>
        <form id="newPasswordForm">
            <table>
                <tbody>
                    <tr>
                        <td><label for="password1">Mot de passe actuel :</label></td><td><input type="password" id="password1" name="password1"></td>
                    </tr><tr>
                        <td><label for="password2">Nouveau mot de passe :</label></td><td><input type="password" id="password2" name="password2"></td>
                    </tr><tr>
                        <td><label for="password3">Nouveau mot de passe répété :</label></td><td><input type="password" id="password3" name="password3"></td>
                    </tr><tr>
                        <td colspan="2" class="error"></td>
                    </tr><tr>
                        <td colspan="2"><input id="newPassword" type="submit" class="roundedButton" value="Changer le mot de passe"></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <h4>Changement de votre nom</h4>
        <form id="newNameForm">
            <table>
                <tbody>
                    <tr>
                        <td><label for="name">Votre nom :</label></td>
                        <td><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION["name"]); ?>"></td>
                    </tr><tr>
                        <td colspan="2" class="error"></td>
                    </tr><tr>
                        <td colspan="2"><input id="newName" type="submit" class="roundedButton" value="Changer votre nom"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    
</div>
<?php
global $js;
array_push($js,"js/profile.js");
?>