<?php include 'connect_mysql.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="add_side" style="visibility: visible;">
    <h1>Add side</h1>
    <form method="post">
        <input type="hidden" id="add_side" name="add_side" value="add_side">
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


<div>
    <h1>Engage lesson</h1>
    <form method="post">
        <input type="hidden" id="engage_les" name="engage_les" value="engage_les">
        <label for="meet_side">Choose where we meet:</label>
        <select name="meet_side" id="meet_side" require>       
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
        <label for="message">Write some message:</label>
        <input type="text" id="message" name="message">
        <br>
        <input type="submit" value="send">
    </form>

</div>


</body>
</html>