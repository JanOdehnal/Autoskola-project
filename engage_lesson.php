<html>
<div id="meet_add" style="visibility: visible;">
    <h1>Engage lesson</h1>
    <form method="post">
        <label for="start_date">date:</label>
        <p id="start_date" name="start_date"></p>
        <input type="hidden" id="start_date_" name="start_date_">
        <label for="start_hour">time:</label>
        <p id="start_hour"></p>
        <input type="hidden" id="start_hour_" name="start_hour_">
        <label for="lector_name">lector name:</label>
        <p id="lector_name"></p>
        <input type="hidden" id="lector_name_" name="lector_name_">
        <label for="meet_side">Choose where we meet:</label>
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
        <input type="submit" value="send">
    </form>
    <button onclick="change_visibility('meet_add')">Back</button>
</div>

</html>

<script>
    function change_vis(lector, pos_hour, date)
    {
        //console.log(lector+"___"+pos_hour+"__"+date);
        document.getElementById("meet_add").style.visibility = "visible";
        document.getElementById("start_date").innerHTML =  date;
        let d = String(date);
        d=d.split(".");
        let date_=d[2]+"-"+d[1]+"-"+d[0];
        //console.log(date_)
        document.getElementById("start_date_").value =  date_;
        document.getElementById("start_hour").innerHTML =  document.getElementById(lector+"_0_"+pos_hour).innerHTML;
        document.getElementById("start_hour_").value =  pos_hour;
        document.getElementById("lector_name").innerHTML =  document.getElementById(lector+"_lec").innerHTML;
        document.getElementById("lector_name_").value =  lector;
    }
</script>

<?php
    if(isset($_POST["start_date_"]))
    {
        data_to_db(connect_mysqli(), "INSERT into timetable(lesson_date, lesson_num, student_id, sides_id) values ('" .$_POST["start_date_"]. "', " .$_POST["start_hour_"]. ", " .$_SESSION["info"]["id"]. ", " .$_POST["meet_side"]. ") ");
    }

?>