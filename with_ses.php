<?php
require_once "navigation.php";
session_start();
include_once "connect_mysqli.php";
$con = connect_mysqli();
?>
<script src="javascript.js"></script>
<html>
    <link rel="stylesheet" href="css.css"> 
    <div id="hello"></div>
    <div id="logs"></div>
</html>

<?php
require_once "log_out.php";
require_once "log_in.php";

//

if (isset($_SESSION["info"]))
{
    echo "<script>document.getElementById('log_sign').style.visibility = 'hidden';</script>";
    require_once "passed_lesson.php";
    if ($_SESSION["possicion"] == "student")
    {
        echo "<script>document.getElementById('hello').innerHTML = 'Hello student ".$_SESSION["info"]["name"]." ".$_SESSION["info"]["surname"]."!'</script>";
        ?>
        <html>
            <h1 onclick="change_visibility('add_side', true)">Add side</h1>
            <h1 onclick="change_visibility('hours', true)">wiew hours</h1>
        </html>
        <?php
        require_once "add_side.php";
        require_once "hours.php";
    }
    else if ($_SESSION["possicion"] == "lector")
    {
        if ($_SESSION["info"]["possicion"] == "lector")
        {
            echo "<script>document.getElementById('hello').innerHTML = 'Hello lector ".$_SESSION["info"]["name"]." ".$_SESSION["info"]["surname"]."!'</script>";
            ?>
            <html>
                <h1 onclick="change_visibility('add_side', true)">Add side</h1>
                <h1 onclick="change_visibility('del_side', true)">Delete side</h1>
            </html>
            <?php
            require_once "add_side.php";
            require_once "delete_side.php";
        }
        else
        {
            echo "<script>document.getElementById('hello').innerHTML = 'Hello admin ".$_SESSION["info"]["name"]." ".$_SESSION["info"]["surname"]."!'</script>";
            ?>
            <html>
                <h1 onclick="change_visibility('add_side', true)">Add side</h1>
                <h1 onclick="change_visibility('del_side', true)">Delete side</h1>

                <h1 onclick="change_visibility('add_veh', true)">Add course</h1>
                <h1 onclick="change_visibility('del_veh', true)">Delelte course</h1>

                <h1 onclick="change_visibility('add_person_1_', true)">Add person</h1>
                <h1 onclick="change_visibility('find_person', true)">Find person</h1>
            </html>
            <?php
            require_once "add_side.php";
            require_once "delete_side.php";
            require_once "add_person_1.php";
            require_once "add_delete_vehicle.php";
            require_once "add_edit.php";
            require_once "find_person.php";
        }
    }
}
else
{
    echo "<script>document.getElementById('hello').innerHTML = 'Hello spectacullar!'</script>";
}
require_once "create_timetable.php";
?>


