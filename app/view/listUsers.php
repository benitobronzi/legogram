<div style="display:block" id="userspage">
    Liste des utilisateurs :<br>
    <hr>
    <table id="table_users">
        <thead>
            <tr>
                <th>
                    Pseudo
                </th>
                <th>
                    Nom
                </th>
                <th>
                    Effacer ?
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            global $users;
            foreach ($users as $user) { //On l'écrit à l'inverse de python le foreach
            ?>
                <tr>
                    <td>
                        <?php
                        echo $user["login"];
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $user["name"];
                        ?>
                    </td>
                    <!-- <td><button onclick="deleteUser('$user[\"login"]')">Ok</button></td> Pq ça fonctionne pas ?  -->
                <?php
                echo "<td><button onclick=\"deleteUser('" . htmlspecialchars($user["login"]) . "')\">Ok</button></td>";
            }
                ?>
                </tr>
        </tbody>
    </table>
    <br>
</div>
<?php
    global $js;
    array_push($js,"js/allUsers.js");
?>