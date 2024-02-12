<html>
<div id="meet_add" class="jump_div">
    <h1 id="h1_eng">Engage lesson</h1>
    <form method="post">
        date:<p id="start_date" name="start_date"></p>
        <input type="hidden" id="sign_off" name="sign_off">
        <input type="hidden" id="start_date_" name="start_date_">
        time:<p id="start_hour"></p>
        <input type="hidden" id="start_hour_" name="start_hour_">
        lector name:<p id="lector_name"></p>
        <input type="hidden" id="lector_name_" name="lector_name_">
        <label for="meet_side">Meet side:</label>
        <select name="meet_side" id="meet_side" require>  
        <!--<label for="start_hour">time:</label> why!!!!!!!!!!!!!!!
        <input type="time" id="start_hour">
        <br>   -->  
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
        <input type="submit" value="Send">
    </form>
    <button onclick="change_visibility('meet_add')">Back</button>
</div>

</html>

<?php
    if(isset($_POST["start_date_"]))
    {
        
        if ($_POST["sign_off"] == true) data_to_db(connect_mysqli(), "DELETE from timetable where lesson_date = '" .$_POST["start_date_"]. "' && lesson_num = ".$_POST["start_hour_"]);
        else data_to_db(connect_mysqli(), "INSERT into timetable(lesson_date, lesson_num, student_id, sides_id) values ('" .$_POST["start_date_"]. "', " .$_POST["start_hour_"]. ", " .$_SESSION["info"]["id"]. ", " .$_POST["meet_side"]. ") ");
    }

?>