<html>
    <div id="del_side" class="jump_div">
        <h1>Smazat místo</h1>
        <form method="post">
            <label for="mod_side">Smazat místo: </label>
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
            <input type="submit" value="Smazat místo">
        </form>
        <button onclick="change_visibility('del_side', false)">Zpět</button>
    </div>
</html>
<?php
if (isset($_POST["mod_side"]))
{
    data_to_db($con, "UPDATE sides SET visibility = 'false' WHERE (id = " .$_POST["mod_side"]. ")");
    echo "<script>document.getElementById('logs').innerHTML = 'Smazal jsi místo!'</script>";
    echo "<script>location.reload()</script>";
}
?>