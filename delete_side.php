<html>
    <div id="del_side" style="visibility: visible;">
        <h1>Delete side</h1>
        <form method="post">
            <label for="mod_side">Delete side: </label>
            <select name="mod_side" id="mod_side" require>       
    <?php
        $query = "select id, town, street, GPS_coordinate, more_info from sides";
        if ($stmt = $con->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($id, $town, $street, $GPS_coordinate, $more_info);
            while ($stmt->fetch()) {
                echo '<option value="' . $id . '">' .$town. ', ' .$street. ', ' .$GPS_coordinate. ', ' .$more_info. '</option>';
            }
            $stmt->close();
        }
    ?>
            </select>
            <br>
            <input type="submit" value="Delete side">
        </form>
    </div>
</html>
<?php
if (isset($_POST["mod_side"]))
{
    data_to_db($con, "DELETE FROM sides WHERE id=".$_POST["mod_side"]);
}
?>