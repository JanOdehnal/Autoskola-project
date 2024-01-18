<html>
    <div>
        <h1>Engage lesson</h1>jine upravit!!!
        <br>
        <form method="post">
            <input type="hidden" id="engage_les" name="engage_les" value="engage_les">
            <label for="meet_side">Choose where we meet:</label>
            <select name="meet_side" id="meet_side" require>       
    <?php
        $query = "SELECT id, town, street, GPS_coordinate, more_info from sides";
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
</html>

<?php





?>