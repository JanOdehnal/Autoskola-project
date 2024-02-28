<?php
require_once "navigation.php";
session_start();
include_once "connect_mysqli.php";
include_once "connect_PHPmailer.php";
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
//require_once "edit_timetable.php";

if (isset($_SESSION["info"]))
{
    echo "<script>document.getElementById('log_sign').style.visibility = 'hidden';</script>";
    require_once "passed_lesson.php";
    if ($_SESSION["possicion"] == "student")
    {
        echo "<script>document.getElementById('hello').innerHTML = 'Dobrý den ".$_SESSION["info"]["name"]." ".$_SESSION["info"]["surname"]."!'</script>";
        ?>
        <html>
            <h1 onclick="change_visibility('add_side', true)">Přidat místo</h1>
            <h1 onclick="change_visibility('hours', true)">Moje hodiny</h1>
        </html>
        <?php
        require_once "add_side.php";
        require_once "hours.php";
    }
    else if ($_SESSION["possicion"] == "lector")
    {
        if ($_SESSION["info"]["possicion"] == "lector")
        {
            echo "<script>document.getElementById('hello').innerHTML = 'Dobrý den lector ".$_SESSION["info"]["name"]." ".$_SESSION["info"]["surname"]."!'</script>";
            ?>
            <html>
                <h1 onclick="change_visibility('add_side', true)">Přidat místo</h1>
                <h1 onclick="change_visibility('del_side', true)">Smazat místo</h1>
            </html>
            <?php
            require_once "add_side.php";
            require_once "delete_side.php";
        }
        else
        {
            echo "<script>document.getElementById('hello').innerHTML = 'Dobrý den admin ".$_SESSION["info"]["name"]." ".$_SESSION["info"]["surname"]."!'</script>";
            ?>
            <html>
                <h1 onclick="change_visibility('add_side', true)">Přidat místo</h1>
                <h1 onclick="change_visibility('del_side', true)">Smazat místo</h1>
                <h1 onclick="change_visibility('add_veh', true)">Přidat kurz</h1>
                <h1 onclick="change_visibility('del_veh', true)">Smazat kurz</h1>
                <h1 onclick="change_visibility('add_person_1_', true)">Přidat osobu</h1>
                <h1 onclick="change_visibility('find_person', true)">Najít osobu</h1>
                <h1 onclick="change_visibility('edit_timeteble', true)">Změnit rozvh</h1>
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
    echo "<script>document.getElementById('hello').innerHTML = 'Dobrý den návštěvníku!'</script>";
}
require_once "create_timetable.php";
?>


