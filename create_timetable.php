<html>
<div id="meet_add" style="visibility: hidden;">
    <h1>Engage lesson</h1>
    <form method="post">
        <p id="start_date"></p>
        <p id="start_hour"></p>
        <p id="lector_id"></p>
        <input type="hidden" id="engage_les" name="engage_les" value="engage_les">
        <label for="meet_side">Choose where we meet:</label>
        <select name="meet_side" id="meet_side" require>       
<?php
    /*$query = "select id, town, street, GPS_coordinate, more_info from sides";
    if ($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($id, $town, $street, $GPS_coordinate, $more_info);
        while ($stmt->fetch()) {
            echo '<option value="' . $id . '">' .$town. ', ' .$street. ', ' .$GPS_coordinate. ', ' .$more_info. '</option>';
        }
        $stmt->close();
    }*/
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

<script>
    function change_vis(lector, pos_hour, date)
    {
        console.log(lector+"_0_"+pos_hour);
        document.getElementById("meet_add").style.visibility = "visible";
        document.getElementById("start_date").innerHTML = "This lesson starts at: " + date;
        document.getElementById("start_hour").innerHTML = "at: " + document.getElementById(lector+"_0_"+pos_hour).innerHTML;
        document.getElementById("lector_id").innerHTML = "with: " +document.getElementById(lector+"_lec").innerHTML;
    }
    function new_timetable()
    {
        
    }


</script>

<?php

class Timetable
{
    private $duration;
    private $num_less;
    private $time_less;
    private $weeks;
    function get_weeks(){return $this->weeks;}
    function get_duration(){return $this->duration;}
    function get_num_less(){return $this->num_less;}
    function get_time_less(){return $this->time_less;}
    function set_weeks($weeks){ $this->weeks=$weeks;}
    /*function set_duration(){$this->duration;}
    function set_num_less(){$this->num_less;}
    function set_time_less(){$this->time_less;}*/

    function set_data($weeks, $num_less, $duration, $array)
    {
        $this->weeks = $weeks;
        $this->num_less = $num_less;
        $this->duration = $duration;
        $this->time_less = $array;
    }
}

$my_timetable = new Timetable();
$my_timetable->set_data(3, 5, 90, ["00:00", "01:00", "02:00", "03:00", "04:00"]);
echo $my_timetable->get_time_less()[0];
echo $my_timetable->get_weeks()."class<br>";


function get_last_Monday()
{
    $ls_mon=time();
    date("w", $ls_mon);
    for ($i = 0; $i < 7; $i++)
    {
        if (date("w", $ls_mon-24*3600*$i) == 1)
        {
            return $ls_mon-24*3600*$i;
        }
    }
}


function get_day($sec_day)
{
    $days=["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Satusday"];
    return $days[date("w", $sec_day)];
}

function create_table($lector, $my_timetable)
{
    echo "<h1 id='" .$lector."_lec". "'>Lector</h1>";
    $tmp=0;//use with sec - day
    $last_Mo=get_last_Monday();
    for ($h=0; $h < $my_timetable->get_weeks();$h++) // num of weeks
    {
        $plas_week=7*24*3600*$h;
        $table="<table border='1px solid black'>";
        $table=$table."<tr>";
        for ($j = 0; $j < $my_timetable->get_num_less()+1; $j++)//number of hours
        {
            if ($h == 0 && $j == 0) $table=$table."<td>This week</td>";
            else if ($j==0) $table=$table."<td>" .$h. ". week</td>";
            else $table=$table."<td id='" .$lector."_". $h ."_". $j . "'>".$my_timetable->get_time_less()[$j-1]."</td>";
        }
        $table=$table."</tr>";
        for ($i = 0; $i < 7; $i++)// number of days
        {
            $table=$table."<tr>";
            for ($j = 0; $j < $my_timetable->get_num_less()+1; $j++)// hours again
            {
                $tmp=$last_Mo+24*3600*$i+$plas_week;
                if ($j == 0) $table=$table."<td>".date("d.m.Y", $tmp).", ".get_day($tmp)."</td>";
                else $table=$table."<td id='" .$lector. "_" . date("d-m-Y", $tmp) . "_" .$i. "' onclick=\"change_vis('" .$lector."','" . $j ."','".date("d-m-Y", $tmp). "')\">some text</td>";
            }
            $table=$table."</tr>";
        }
        $table=$table."</table><br>";
        echo $table;
    }
}
create_table(1, $my_timetable);

/*
spectacullar
student 1times || all
lector 1times
admin all
*/

?>

<html>

<div id="edyt_timetable" style="visibility: visible;">
    <h1>Edyt timetable</h1>
    <form method="post">
<?php
    echo "<label for='time_t_weeks'>Num of weeks for future:</label>
        <input id='time_t_weeks' type='number' min='0' value=".$my_timetable->get_weeks().">
        <br>
        <label for='timet_dur'>Duration:</label>
        <input id='timet_dur' type='number' min='0' value=".$my_timetable->get_duration().">
        <br>";
    for ($i=1;$i<$my_timetable->get_num_less()+1;$i++)//count of hours solve after
    {
        echo "<label for='tim_h_".$i."'>".$i. " hour:</label>
            <input type='time' id='tim_h_". $i ."' value='". $my_timetable->get_time_less()[$i-1] . "'><br>";
    }
?>
        <input type="submit" value="Edyt">
    </form>
</div>

<p id="edyt_smf"></p>

</html>
<?php //dodelat info ze souboru
if ($_POST)
{    
    if (isset($_POST["time_t_weeks"]))
    { 
        $my_timetable->set_weeks($_POST["time_t_weeks"]);

    }
}

?>