


<!--after find person-->
<html>
    <div id="add_person_2" class="jump_div_super">
        <h1>Add new person</h1>
        <form method="POST">
            <input type="hidden" id="reg" name="reg" value="">
            <input type="hidden" id="reg_" name="reg_" value="">
<br/>
*In what vehicle will student drive? / Lector prefer:<br>
<?php
$con = connect_mysqli();
$query = "SELECT id, vehicle_type, num_of_less, visibility from course";
if ($stmt = $con->prepare($query)) {
$stmt->execute();
$stmt->bind_result($id, $vehicle, $lesson_num, $visibility);
while ($stmt->fetch()) {
    if ($visibility == 'true') echo '<input onclick = "add_hours('.$lesson_num.')" type="radio" id="'. $vehicle .'" name="type_veh" value="'. $id .'">
        <label for="'. $vehicle .'">'. $vehicle .'</label>';
}
$stmt->close();
}
?>
<br>
<div id="if_student" style="visibility: hidden;">
    <label for="choose_lec">Choose lector: </label>
    <select name="choose_lec" id="choose_lec">
<?php
$query = "SELECT id, name, surname, email from lector";
if ($stmt = $con->prepare($query)) {
$stmt->execute();
$stmt->bind_result($id, $name, $surname, $email);
while ($stmt->fetch()) {
    echo '<option value="' . $id . '">' . $name .' ,' . $surname . ' ,' . $email . '</option>';
}
$stmt->close();
}
?>
    </select>
    <br>
    <label for="hour_num">Student will have </label>
    <input type="number" id="hour_num" name="hour_num">
    <label for="hour_num">hours.</label>
</div>
<div id="active_lec" style="visibility: hidden;">
    <input type="radio" id="adm" name="pos2" value="admin">
    <label for="adm">Admin</label>
    <input type="radio" id="lec" name="pos2" value="lector">
    <label for="lec">Lector</label>
    <br>
    <input type="radio" id="active" name="if_activ" value="activ">
    <label for="active">Active</label>
    <input type="radio" id="passiv" name="if_activ" value="passiv">
    <label for="passiv">Passive</label>
</div>
<input type="submit" value="Registry person">
</form>
<button onclick="change_visibility('add_person_2', false), change_visibility('if_student', false), change_visibility('active_lec', false)">Back</button>
</div>
</html>

<?php

if (isset($_POST["reg"]))
{ 
    if ($_POST["reg"] == "student") // add person
    {
        // add record to student_course_lec
        if ($_POST["type_veh"] == null) echo "<script>document.getElementById('logs').innerHTML = 'You forgot write vehicle type!'</script>";
        else if ($_POST["choose_lec"] == null) echo "<script>document.getElementById('logs').innerHTML = 'You forgot choose lector!'</script>";
        //else if (array_values(mysqli_fetch_assoc(mysqli_query($con, "SELECT count() from student_course_lec where student_id= ".$_POST["reg_"])))[0]!=0) echo "<script>document.getElementById('logs').innerHTML = 'Student can have 1 course'</script>";
        else 
        {
            data_to_db($con, "UPDATE student set verify_pass = ".rand(100000,999999).", lesson_num = ".$_POST["hour_num"]." where id = ".$_POST["reg_"]);
            data_to_db($con, "INSERT into student_course_lec(student_id, course_id, lector_id) values('" .$_POST["reg_"]. "','" .$_POST["type_veh"]. "','" .$_POST["choose_lec"]. "')");
        }
    }
    else
    {
        if ($_POST["if_activ"]==NULL)
        {
            echo "<script>document.getElementById('logs').innerHTML = 'You forgot write if he is active or passiv!'</script>";
            return 0;
        }
        else data_to_db($con, "UPDATE lector set verify_pass = ".rand(100000,999999).", possicion = '".$_POST["pos2"]."', active_lec = '".$_POST["if_activ"]."' where id = ".$_POST["reg_"]);
    }
    //mail("ode2@seznam.cz", "You were log in in driving school", "You were log in in driving school. Your verifycation code is: " .rand(100000, 999999). ".");
    // last if delte if
    //send email with verificational password // current net working
}
?>