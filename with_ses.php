<?php
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

require_once "find_person.php";//

if (isset($_SESSION["info"]))
{
    require_once "passed_lesson.php";
    if ($_SESSION["possicion"] == "student")
    {
        echo "<script>document.getElementById('hello').innerHTML = 'Hello student ".$_SESSION["info"]["name"]." ".$_SESSION["info"]["surname"]."!'</script>";
        require_once "add_side.php";
        //require_once "engage_lesson.php";
    }
    if ($_SESSION["possicion"] == "lector")
    {
        if ($_SESSION["info"]["possicion"] == "lector")
        {
            echo "<script>document.getElementById('hello').innerHTML = 'Hello lector ".$_SESSION["info"]["name"]." ".$_SESSION["info"]["surname"]."!'</script>";
            require_once "add_side.php";
            require_once "delete_side.php";
        }
        else
        {
            echo "<script>document.getElementById('hello').innerHTML = 'Hello admin ".$_SESSION["info"]["name"]." ".$_SESSION["info"]["surname"]."!'</script>";
            require_once "add_side.php";
            require_once "delete_side.php";
            require_once "add_person.php";
            require_once "add_delete_vehicle.php";
            //require_once "engage_lesson.php";

        }
    }
}
else
{
    echo "<script>document.getElementById('hello').innerHTML = 'Hello spectacullar!'</script>";
}
require_once "create_timetable.php";
?>


