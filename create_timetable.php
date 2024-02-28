<?php

class Timetable
{
    private $duration;
    private $num_less;
    private $time_less;
    private $weeks;
    private $registry;
    function get_weeks(){return $this->weeks;}
    function get_duration(){return $this->duration;}
    function get_num_less(){return $this->num_less;}
    function get_time_less(){return $this->time_less;}
    function get_registry(){return $this->registry;}
    function set_weeks($weeks){ $this->weeks=$weeks;}

    function set_data($duration)
    {
        $this->duration = $duration;
        if ($time = mysqli_fetch_assoc(mysqli_query(connect_mysqli(), "SELECT * from time_info")))
        {
            $this->num_less=$time["num_less_per_day"];
            $this->weeks=$time["vis_weeks"];
            $this->registry=$time["time_take"];
            $this->time_less=explode("-", $time["times"]);

        }
    }
}

$my_timetable = new Timetable();
$my_timetable->set_data(45);


function get_last_Monday()
{
    $ls_mon=time()-time()%(24*3600);
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
    $days=["Neděle", "Pondělí", "Úterý", "Středa", "Čtvrtek", "Pátek", "Sobota"];
    return $days[date("w", $sec_day)];
}

function create_table($lector_row, $my_timetable)
{

    echo "<h1 id='" .$lector_row["id"]."_lec". "'>" .$lector_row["name"]. " " .$lector_row["surname"]. "</h1>";
    $tmp=0;//use with sec - day
    $last_Mo = get_last_Monday();

    $sql="SELECT distinct x.* , y.lector_id, z.*, a.*, b.* from timetable x left join student_course_lec y on x.student_id = y.student_id left join sides z on x.sides_id = z.id left join student a on x.student_id = a.id left join course b on b.id = y.course_id where x.lesson_date >= '".date("Y-m-d", get_last_Monday())."' and  teacher_id=" .$lector_row["id"]. " ORDER BY x.lesson_date, x.lesson_num;";

    $sql_stat = mysqli_query(connect_mysqli(), $sql);
    $no_records = false;
    if (!$row_t = mysqli_fetch_assoc($sql_stat))
    {
        $no_records = true;
        //echo "NO RECORDS";
    }
    for ($h=0; $h < $my_timetable->get_weeks();$h++) // num of weeks
    {
        $plas_week=7*24*3600*$h;
        $table="<table border='1px solid black'>";
        $table=$table."<tr>";
        for ($j = 0; $j < $my_timetable->get_num_less()+1; $j++)//number of hours
        {
            if ($h == 0 && $j == 0) $table=$table."<td>Tento týden</td>";
            else if ($j==0) $table=$table."<td>" .$h. ". week</td>";
            else $table=$table."<td class='else' id='" .$lector_row["id"]."_". $h ."_". $j . "'>".$my_timetable->get_time_less()[$j-1]."</td>";// bez id
        }
        $table=$table."</tr>";
        for ($i = 0; $i < 5; $i++)// number of days
        {
            $table=$table."<tr>";
            for ($j = 0; $j < $my_timetable->get_num_less()+1; $j++)// hours again
            {
                $tmp=$last_Mo+24*3600*$i+$plas_week;
                if ($j == 0) $table=$table."<td class='else'>".date("d.m.Y", $tmp).", ".get_day($tmp)."</td>";//1st col date...
                else if (!$no_records && $row_t["lesson_date"] == date("Y-m-d", $tmp) && $row_t["lesson_num"] == $j)
                {
                    if ($row_t["student_id"] == 1)
                    {
                        if (isset($_SESSION["info"]) && $_SESSION["possicion"]!="student")
                        {
                            if ($_SESSION["info"]["possicion"]=="admin") $table=$table."<td onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 4)\" class='taken'>Autoškola</td>";
                            else if ($_SESSION["info"]["possicion"]=="lector") $table=$table."<td onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 1)\" class='taken'>Autoškola info</td>";
                        }
                        else $table=$table."<td class='taken'>driving school</td>";
                    }
                    else if (isset($_SESSION["possicion"]))
                    {
                        //TODO if finish, checked
                        if ($_SESSION["possicion"]=="student" && $row_t["student_id"]==$_SESSION["info"]["id"]) //for student
                        {  
                            if ($row_t["finish_lesson"]=="true") $table=$table."<td class='taken'>Tvoje hodina proběhla.</td>";
                            else if ($row_t["finish_lesson"]=="false") $table=$table."<td class='taken'>Tvoje hodina neproběhla.</td>";
                            else if (time()+$my_timetable->get_registry()*3600 > $tmp+strtotime($my_timetable->get_time_less()[$j-1].":00")-strtotime("00:00:00"))$table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 0)\" class='taken'>Zákaz změny.</td>";
                            else $table=$table."<td class='taken' onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 2)\" class='taken'>info/smazat</td>";
                        }
                        else if ($_SESSION["possicion"]=="lector") //for lectors
                        {
                            if ($_SESSION["info"]["possicion"]=="lector")//for lector
                            {
                                if ($row_t["finish_lesson"]=="true") $table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].", '".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 1, '".$row_t["vehicle_type"]."', '".$row_t["name"]." ".$row_t["surname"]."')\" class='taken'>Hodina proběhla.</td>";
                                else if ($row_t["finish_lesson"]=="false") $table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 1, '".$row_t["vehicle_type"]."', '".$row_t["name"]." ".$row_t["surname"]."')\" class='taken'>Hodina neproběhla.</td>";
                                else if (time()-300 < $tmp+strtotime($my_timetable->get_time_less()[$j-1].":00")-strtotime("00:00:00")+$my_timetable->get_duration()*60) $table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 0, '".$row_t["vehicle_type"]."', '".$row_t["name"]." ".$row_t["surname"]."')\" class='taken'>Hodina ještě neskončila</td>";
                                else $table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 1, '".$row_t["vehicle_type"]."', '".$row_t["name"]." ".$row_t["surname"]."')\" class='taken'>Vyplň</td>";
                            }
                            if ($_SESSION["info"]["possicion"]=="admin")//for admin
                            {
                                if ($row_t["finish_lesson"]=="true") $table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 4, '".$row_t["vehicle_type"]."', '".$row_t["name"]." ".$row_t["surname"]."')\" class='taken'>Hodina proběhla.</td>";
                                else if ($row_t["finish_lesson"]=="false") $table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 4, '".$row_t["vehicle_type"]."', '".$row_t["name"]." ".$row_t["surname"]."')\" class='taken'>Hodina neproběhla.</td>";
                                else if (time()-300 < $tmp+strtotime($my_timetable->get_time_less()[$j-1].":00")-strtotime("00:00:00")+$my_timetable->get_duration()*60) $table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 2, '".$row_t["vehicle_type"]."', '".$row_t["name"]." ".$row_t["surname"]."')\" class='taken'>Hodina ještě neskončila</td>";
                                else $table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 4, '".$row_t["vehicle_type"]."', '".$row_t["name"]." ".$row_t["surname"]."')\" class='taken'>Vyplň</td>";
                            }
                        }
                        else $table=$table."<td  onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'".$row_t["town"].", ".$row_t["street"].", ".$row_t["GPS_coordinate"]."', 0, '".$row_t["vehicle_type"]."', '".$row_t["name"]." ".$row_t["surname"]."')\" class='taken'>Zabráno</td>"; 
                    }
                    else $table=$table."<td class=\"taken\">Zabráno</td>";
                    if(!$row_t = mysqli_fetch_assoc($sql_stat)) $no_records = true; 
                }
                else if (isset($_SESSION["possicion"]))
                {
                    if ($_SESSION["possicion"]=="lector" && $_SESSION["info"]["possicion"]=="lector") $table=$table."<td class=\"free\">Volná hodina</td>";
                    else if ($_SESSION["possicion"]=="student")
                    {
                        if (time()+$my_timetable->get_registry()*3600 < $tmp+strtotime($my_timetable->get_time_less()[$j-1].":00")-strtotime("00:00:00")) $table=$table."<td class='free' onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'', 3)\" class='free'>Zabrat hodinu</td>";
                        else $table=$table."<td class=\"free\">Volno</td>";
                    }
                    else if ($_SESSION["possicion"]=="lector" && $_SESSION["info"]["possicion"]=="admin") $table=$table."<td class='free' onclick=\"check_lesson(" .$j. ", '" .date("d.m.Y", $tmp). "', ".$lector_row["id"].",'', 3)\" class='free'>Zabrat hodinu</td>";
                }
                else $table=$table."<td class='free'>Volno</td>";
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
    if ($row["active_lec"]=="activ") 
    {
        if (!isset($_SESSION["info"])) create_table($row, $my_timetable);
        else if ($_SESSION["possicion"] == "student" && $_SESSION["info"]["lector_id"]==$row["id"]) create_table($row, $my_timetable);
        else if ($_SESSION["possicion"] == "lector" && $_SESSION["info"]["possicion"] == "admin") create_table($row, $my_timetable);
        else if ($_SESSION["possicion"] == "lector" && $_SESSION["info"]["possicion"] == "lector" && $_SESSION["info"]["id"] == $row["id"]) create_table($row, $my_timetable);
    }
}


/*
spectacullar all
student 1times || all
lector 1times
admin all
*/
?>
<html>
    <div id="edit_timeteble" class="jump_div">
        <h1>Změna rozvhu</h1>
        <form method="post">
            <label for="add_les">Přidej hodinu v:</label>
            <input type="time" id="add_les" name="add_les">
            <br>
            <label for="del_les">Smazat poslední hodinu(ověř si, ži ji nikdo nema!):</label>
            <input type="radio" id="del_les" name="del_les">
            <br>
            <input type="submit" value="Poslat">
        </form>
        <button onclick="change_visibility('edit_timeteble', false)">Zpět</button>
    </div>
</html>

<?php
require_once "connect_mysqli.php";

if (isset($_POST["add_les"]))
{
    if($_POST["add_les"]!=null)
    {
        $times ="";
        foreach ($my_timetable->get_time_less() as $cell)
        {
            $times = $times.$cell."-";
        }
        $times = $times.$_POST["add_les"];
        data_to_db(connect_mysqli(), "UPDATE time_info set num_less_per_day = ".($my_timetable->get_num_less()+1)." , times = '".$times."'");
        echo "<script>document.getElementById('logs').innerHTML = 'Hodina přidana!'</script>";
    }
    if($_POST["del_les"]!=null)
    {
        $times ="";
        $tmp=true;
        foreach ($my_timetable->get_time_less() as $cell)
        {
            if ($tmp)
            {
                $tmp = false;
                $times = $times.$cell;
            }
            else $times = $times."-".$cell;
        }
        if ($my_timetable->get_num_less() > 0)data_to_db(connect_mysqli(), "UPDATE time_info set num_less_per_day = ".($my_timetable->get_num_less()-1)." , times = '".$times."'");
        echo "<script>document.getElementById('logs').innerHTML = 'Hodina odebrana!'</script>";
    }

}

?>