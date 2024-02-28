<html>
    <div id="add_delete" class="jump_div_super">
        <h1 id="del_add">Přidat hodinu</h1>
        <form method="post">
            <input type="hidden" name="pos_contin_p" id="pos_contin_p">
            <input type="hidden" name="pos_contin_i" id="pos_contin_i">
            <div id="add_hours" style="visibility:hidden">
                <label for="num_h">Počet hodin:</label>
                <input type="number" name="num_h" id="num_h" value="0">
                <br>
                <input type="submit" value="Přidej">
            </div>
            <div id="delete_pers" style="visibility:hidden">
                <input type="radio" name="del_pers" id="del_pers" value="del">
                <label for="del_pers">Smazat</label>
                <br>
                <input type="submit" value="Smazat!">
            </div>
        </form>
    <button onclick="change_visibility('add_hours', false), change_visibility('add_delete', false), change_visibility('delete_pers', false)">Back</button>
    </div>
</html>

<?php
if (isset($_POST["num_h"]))
{
    if ($_POST["pos_contin_p"] == "student" && $_POST["num_h"]==0);
    else if ($row=mysqli_fetch_assoc(mysqli_query(connect_mysqli(), "SELECT * from ".$_POST["pos_contin_p"]." where id = ".$_POST["pos_contin_i"])))
    {
        data_to_db(connect_mysqli(), "UPDATE student SET lesson_num_h = ".($row["lesson_num_h"]+$_POST["num_h"])." where id = ".$_POST["pos_contin_i"]);
        echo "<script>document.getElementById('logs').innerHTML = 'Přidal jsi ".$_POST["num_h"]." hodin ".$row["name"]." ".$row["surname"]."!'</script>";
        echo "<script>location.reload()</script>";
        return 0;
    }
    /*
    }*/
}

if (isset($_POST["del_pers"]))
{
    if ($_POST["del_pers"]==null) return 0;
    if ($_POST["del_pers"]==null) return 0;
    {
        if ($_POST["pos_contin_p"]=="student")
        {
            data_to_db(connect_mysqli(), "DELETE from timetable where student_id= ".$_POST["pos_contin_i"]);
            data_to_db(connect_mysqli(), "DELETE from student_course_lec where student_id= ".$_POST["pos_contin_i"]);
            data_to_db(connect_mysqli(), "DELETE from student where id= ".$_POST["pos_contin_i"]);
            echo "<script>document.getElementById('logs').innerHTML = 'Smazal jsi studenta!'</script>";
        }
        else
        {
            return 0;
        }
    }
}
?>