<html>
<div id="finish_less" class="jump_div">
    <h1 id="h1_finish">Checked lesson</h1>
    <form method="post">
        date:<p id="start_date_f"></p>
        <input type="hidden" id="start_date_f_" name="start_date_f_">
        time:<p id="start_hour_f"></p>
        <input type="hidden" id="start_hour_f_" name="start_hour_f_">
        <p id="meet_s"><p>
        <p id="type_car"><p>
        <div id="choose_side" style="visibility:hidden"><!--for student-->
            <input type="hidden" name="change" id="change" value="">
            <label for="meet_side">Meet side:</label>
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
            <input type="submit" value="Send">
        </div>
        <div id="finish_vis" style="visibility:hidden"><!--for lector and admin -->
            <label for="success">Lesson finish:</label>
            <br>
            <input type="radio" value="true" name="finish" id="success" require>
            <label for="success">true</label>
            <input type="radio" value="false" name="finish" id="unsuccess">
            <label for="unsuccess">false</label>
            <br>
            <input type="submit" value="Send">
        </div>
        <div id="delete" style="visibility:hidden"><!--for admin and student-->
            <input type="radio" value="del" name="del" id="del" require>
            <label for="del">Delete</label>
            <input type="submit" value="Send">
        </div>
    </form>
    <button onclick="change_visibility('finish_less', false), change_visibility('choose_side', false), change_visibility('finish_vis', false), change_visibility('delete', false)">Back</button>
</div>
</html>

<script>
    function check_lesson(pos_hour, date, lector, side, info)
    {
        if (info==0);//info
        else if (info==1)//chack lesson
        {
            document.getElementById("finish_vis").style.visibility = "hidden";
            document.getElementById("h1_finish").innerHTML = "Info about lesson";
        }
        else if (info==2)//delete lesson
        {
            document.getElementById("delete").style.visibility = "visible";
            document.getElementById("h1_finish").innerHTML = "Delete/replace lesson";
            document.getElementById("choose_side").style.visibility = "visible";
            document.getElementById("change").value = "change";
        }
        else if (info==3)//choose lesson
        {
            document.getElementById("choose_side").style.visibility = "visible";
            document.getElementById("h1_finish").innerHTML = "Take lesson";
        }
        else if (info==4)//chack, replace and delete 
        {
            document.getElementById("finish_vis").style.visibility = "visible";
            document.getElementById("delete").style.visibility = "visible";
            document.getElementById("choose_side").style.visibility = "visible";
            document.getElementById("h1_finish").innerHTML = "Check/delete/replace";
            document.getElementById("change").value = "change";
        }
        document.getElementById("finish_less").style.visibility = "visible";
        document.getElementById("start_date_f").innerHTML =  date;
        let d = String(date);
        d=d.split(".");
        document.getElementById("start_date_f_").value =  d[2]+"-"+d[1]+"-"+d[0];
        document.getElementById("start_hour_f").innerHTML =  document.getElementById(lector+"_0_"+pos_hour).innerHTML;
        document.getElementById("start_hour_f_").value =  pos_hour;
        document.getElementById("meet_s").innerHTML = "side: "+side;
    }
</script>

<?php

if(isset($_POST["start_date_f_"]))
{  
    if (isset($_POST["del"]) && $_POST["del"] == "del")
    {
        /*if (isset($_SESSION["possicion"]) && $_SESSION["possicion"] == "admin" && mysqli_fetch_assoc(mysqli_query(connect_mysqli(), "SELECT student_id from timetable where lesson_date =".$_POST["start_hour_f_"]." and lesson_num = ".$_POST["start_hour_f_"])) != 0) //if admin delete student //
        {
            ;//TODO//email
        }*/
        data_to_db(connect_mysqli(), "DELETE from timetable where lesson_date = '" .$_POST["start_date_f_"]. "' && lesson_num = ".$_POST["start_hour_f_"]);
        echo "<script>document.getElementById('logs').innerHTML = 'You delete lessons!'</script>";
    }
    if ($_POST["change"]=="change")
    {
        data_to_db(connect_mysqli(), "UPDATE timetable set sides_id = " .$_POST["meet_side"]. " where lesson_date = '".$_POST["start_date_f_"]."' and lesson_num = ".$_POST["start_hour_f_"]);
    }
    else if ($_POST["meet_side"] != null && $_SESSION["possicion"] == "student")// try
    {
        if (array_values(mysqli_fetch_assoc(mysqli_query(connect_mysqli(), "SELECT count(student_id) from timetable where lesson_date = '" .$_POST["start_date_f_"]. "' and lesson_num = " .$_POST["start_hour_f_"])))[0] > 0)
        {
            echo "<script>document.getElementById('logs').innerHTML = 'Someone was faster!'</script>";
            return 0;
        }
        if (array_values(mysqli_fetch_assoc(mysqli_query(connect_mysqli(), "SELECT count(student_id) from timetable where student_id = " .$_SESSION["info"]["id"])))[0] > $_SESSION["info"]["lesson_num"])
        {
            echo "<script>document.getElementById('logs').innerHTML = 'You pass all your hours!'</script>";
            return 0;
        }
        if (array_values(mysqli_fetch_assoc(mysqli_query(connect_mysqli(), "SELECT count(student_id) from timetable where lesson_date = '" .$_POST["start_date_f_"]. "' and student_id = ".$_SESSION["info"]["id"])))[0] != 0)
        {
            // if lesson 90 min
            echo "<script>document.getElementById('logs').innerHTML = 'You can have only 1 lesson in day!'</script>";
            return 0;
        }
        data_to_db(connect_mysqli(), "INSERT into timetable(lesson_date, lesson_num, student_id, sides_id) values ('" .$_POST["start_date_f_"]. "', " .$_POST["start_hour_f_"]. ", " .$_SESSION["info"]["id"]. ", " .$_POST["meet_side"]. ") ");
        echo "<script>document.getElementById('logs').innerHTML = 'You added lesson succesfuly!'</script>";
        //email
    }
    else //lector take hour
    {
        data_to_db(connect_mysqli(), "INSERT into timetable(lesson_date, lesson_num, student_id, sides_id) values ('" .$_POST["start_date_f_"]. "', " .$_POST["start_hour_f_"]. ", 0 , " .$_POST["meet_side"]. ")");
        echo "<script>document.getElementById('logs').innerHTML = 'You added lesson succesfuly!'</script>";
    }
}
//solve problems finish passed lasson
?>