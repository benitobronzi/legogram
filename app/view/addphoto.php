<div class="nosession">
    <div> <br><br><br><br><br><br><br><br><br><br>
        <form enctype="multipart/form-data" method="POST" action="<?php echo
                                                                    htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
            <label for="image">Image :</label></td>
            <td><input type="file" id="image" name="image"><br>
                <input type="submit" value="Ok" class="roundedButton">
        </form>
    </div>
</div>