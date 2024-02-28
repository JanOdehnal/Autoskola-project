<?php
include_once "connect_mysqli.php";
$con = connect_mysqli();
?>

<html>
    <div id="add_side" class="jump_div_super">
        <h1>Přidej místo</h1>
        <form method="post">
            <label for="town">*Město:</label>
            <input type="text" id="town" name="town">
            <br>
            <label for="street">*Ulice:</label>
            <input type="text" id="street" name="street">
            <br>
            <label for="jps">*GPS:</label>
            <input type="text" id="jps" name="jps">
            <br>
            <label for="info">Více informací:</label>
            <input type="text" id="info" name="info">
            <br>
            <input type="submit" value="Odeslat!">
        </form>
        <button onclick="change_visibility('add_side', false)">Zpět</button>
    </div>
</html>

<?php
if (isset($_POST["town"]))
{
    data_to_db($con, "INSERT into sides(town, street, GPS_coordinate, more_info, visibility) values ('" .$_POST["town"]. "', '" .$_POST["street"]."', '".$_POST["jps"]."', '".$_POST["info"]."', 'true')");
    echo "<script>document.getElementById('logs').innerHTML = 'Přidal jsi místo!'</script>";
}
?>