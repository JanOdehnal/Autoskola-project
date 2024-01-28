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
//echo $my_timetable->get_time_less()[0];
//echo $my_timetable->get_weeks()."class<br>";


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

function create_table($lector_row, $my_timetable)
{

    echo "<h1 id='" .$lector_row["id"]."_lec". "'>" .$lector_row["name"]. " " .$lector_row["surname"]. "</h1>";
    $tmp=0;//use with sec - day
    $last_Mo = get_last_Monday();

    $sql="SELECT  distinct x.* , y.lector_id from timetable x left join student_course_lec y on x.student_id = y.student_id where x.lesson_date >= '".date("Y-m-d", get_last_Monday())."' and y.lector_id=" .$lector_row["id"]. " ORDER BY x.lesson_date, x.lesson_num;";
    //echo $sql;
    $sql_stat = mysqli_query(connect_mysqli(), $sql);
    $no_records = false;
    if (!$row_t = mysqli_fetch_assoc($sql_stat)) $no_records = true; 

    for ($h=0; $h < $my_timetable->get_weeks();$h++) // num of weeks
    {
        $plas_week=7*24*3600*$h;
        $table="<table border='1px solid black'>";
        $table=$table."<tr>";
        for ($j = 0; $j < $my_timetable->get_num_less()+1; $j++)//number of hours
        {
            if ($h == 0 && $j == 0) $table=$table."<td>This week</td>";
            else if ($j==0) $table=$table."<td>" .$h. ". week</td>";
            else $table=$table."<td class='else' id='" .$lector_row["id"]."_". $h ."_". $j . "'>".$my_timetable->get_time_less()[$j-1]."</td>";// bez id
        }
        $table=$table."</tr>";
        for ($i = 0; $i < 7; $i++)// number of days
        {
            $table=$table."<tr>";
            for ($j = 0; $j < $my_timetable->get_num_less()+1; $j++)// hours again
            {
                $tmp=$last_Mo+24*3600*$i+$plas_week;
                if ($j == 0) $table=$table."<td class='else'>".date("d.m.Y", $tmp).", ".get_day($tmp)."</td>";
                else if (!$no_records && $row_t["lesson_date"] == date("Y-m-d", $tmp) && $row_t["lesson_num"] == $j)
                {
                    if ($row_t["student_id"]==$_SESSION["info"]["id"]) $table=$table."<td class='taken'>your lesson</td>";
                    else $table=$table."<td class='taken'>taken</td>";
                    if ($no_records);
                    else if(!$row_t = mysqli_fetch_assoc($sql_stat)) $no_records = true;
                }
                else $table=$table."<td class='free' id='" .$lector_row["id"]. "_" . date("d-m-Y", $tmp) . "_" .$i. "' onclick=\"change_vis('" .$lector_row["id"]."','" . $j ."','".date("d.m.Y", $tmp). "')\">some text</td>";
            }
            $table=$table."</tr>";
        }
        $table=$table."</table><br>";
        echo $table;
    }
}

$tmp_stat=mysqli_query(connect_mysqli(), "SELECT * from lector");
while ($row = mysqli_fetch_assoc($tmp_stat))
{
    create_table($row, $my_timetable);
}


/*
spectacullar all
student 1times || all
lector 1times
admin all
*/

?>

<html>

<!--<div id="edyt_timetable" style="visibility: visible;">
    <h1>Edyt timetable</h1>
    <form method="post">
<?php
    /*echo "<label for='time_t_weeks'>Num of weeks for future:</label>
        <input id='time_t_weeks' type='number' min='0' value=".$my_timetable->get_weeks().">
        <br>
        <label for='timet_dur'>Duration:</label>
        <input id='timet_dur' type='number' min='0' value=".$my_timetable->get_duration().">
        <br>";
    for ($i=1;$i<$my_timetable->get_num_less()+1;$i++)//count of hours solve after
    {
        echo "<label for='tim_h_".$i."'>".$i. " hour:</label>
            <input type='time' id='tim_h_". $i ."' value='". $my_timetable->get_time_less()[$i-1] . "'><br>";
    }*/
?>
        <input type="submit" value="Edyt">
    </form>
</div>

<p id="edyt_smf"></p>
-->
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