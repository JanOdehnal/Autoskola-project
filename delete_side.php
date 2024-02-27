<html>
    <div id="del_side" class="jump_div">
        <h1>Delete side</h1>
        <form method="post">
            <label for="mod_side">Delete side: </label>
            <select name="mod_side" id="mod_side" require>       
    <?php
        $query = "select id, town, street, GPS_coordinate, more_info, visibility from sides";
        if ($stmt = $con->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($id, $town, $street, $GPS_coordinate, $more_info, $visibility);
            while ($stmt->fetch()) {
                if ($visibility=='true') echo '<option value="' . $id . '">' .$town. ', ' .$street. ', ' .$GPS_coordinate. ', ' .$more_info. '</option>';
            }
            $stmt->close();
        }
    ?>
            </select>
            <br>
            <input type="submit" value="Delete side">
        </form>
        <button onclick="change_visibility('del_side', false)">Back</button>
    </div>
</html>
<?php
if (isset($_POST["mod_side"]))
{
    data_to_db($con, "UPDATE sides SET visibility = 'false' WHERE (id = " .$_POST["mod_side"]. ")");
}
?>