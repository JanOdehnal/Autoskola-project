<?php
include_once "connect_mysqli.php";
$con = connect_mysqli();
?>

<html>
    <div id="add_side" style="visibility: visible;">
        <h1>Add side</h1>
        <form method="post">
            <label for="town">Town name:</label>
            <input type="text" id="town" name="town">
            <br>
            <label for="street">Street name:</label>
            <input type="text" id="street" name="street">
            <br>
            <label for="jps">Jps coodinates:</label>
            <input type="text" id="jps" name="jps">
            <br>
            <label for="info">More info:</label>
            <input type="text" id="info" name="info">
            <br>
            <input type="submit" value="Send">
        </form>
    </div>
</html>

<?php
if (isset($_POST["town"]))
{
    data_to_db($con, "INSERT into sides(town, street, GPS_coordinate, more_info, visibility) values ('" .$_POST["town"]. "', '" .$_POST["street"]."', '".$_POST["jps"]."', '".$_POST["info"]."', 'true')");
}
?>