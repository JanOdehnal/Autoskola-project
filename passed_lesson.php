<html>
<div id="finish_less" class="jump_div">
    <h1 id="h1_finish">Checked lesson</h1>
    <form method="post">
        date:<p id="start_date_f"></p>
        <input type="hidden" id="start_date_f_" name="start_date_f_">
        time:<p id="start_hour_f"></p>
        <input type="hidden" id="start_hour_f_" name="start_hour_f_">
        side:<p id="meet_s"><p>
        <div id="finish_vis">
            <label for="success">Lesson finish:</label>
            <br>
            <input type="radio" value="true" name="finish" id="success" require>
            <label for="success">true</label>
            <input type="radio" value="false" name="finish" id="unsuccess">
            <label for="unsuccess">false</label>
            <br>
            <input type="submit" value="Send">
        </div>

    </form>
    <button onclick="change_visibility('finish_less')">Back</button>
</div>
</html>

<script>
    function check_lesson(pos_hour, date, lector, side, info)
    {
        if (info)
        {
            document.getElementById("finish_vis").style.visibility = "hidden";
            document.getElementById("h1_finish").innerHTML = "Info about lesson";
        }
        document.getElementById("finish_less").style.visibility = "visible";
        document.getElementById("start_date_f").innerHTML =  date;
        let d = String(date);
        d=d.split(".");
        document.getElementById("start_date_f_").value =  d[2]+"-"+d[1]+"-"+d[0];
        document.getElementById("start_hour_f").innerHTML =  document.getElementById(lector+"_0_"+pos_hour).innerHTML;
        document.getElementById("start_hour_f_").value =  pos_hour;
        document.getElementById("meet_s").innerHTML = side;
    }
</script>

<?php
if (isset($_POST["start_date_f_"]))
{
    data_to_db(connect_mysqli(), "UPDATE timetable SET finish_lesson = '".$_POST["finish"]."' where lesson_date = '".$_POST["start_date_f_"]."' && lesson_num ='".$_POST["start_hour_f_"]."'");
}



?>