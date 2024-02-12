<html>
    <div id="add_person_form">
        <h1>Add new person</h1>
        <form method="POST">
            *Choode who it is:<br>
            <input type="radio" id="student" name="posicion" value="student" onclick="change_visibility('if_student', true), change_visibility('active_lec', false)" required>
            <label for="student">Student</label>
            <input type="radio" id="lector" name="posicion" value="lector" onclick="change_visibility('active_lec', true), change_visibility('if_student', false)">
            <label for="lector">Lector</label>
            <input type="radio" id="admin" name="posicion" value="admin" onclick="change_visibility('active_lec', true), change_visibility('if_student', false)">
            <label for="admin">Admin</label>
            <br>
            <label for="name">*Name:</label>
            <input id="name" type="text" name="name" required/>
            <br/>
            <label for="surname">*Surname:</label>
            <input id="surname" type="text" name="surname" required/>
            <br/>
            <label for="email">*Email:</label>
            <input id="email" type="email" name="email" required/>
            <br/>
            <label for="tel">*Telephone: +</label>
            <input id="tel" type="tel" value="420" name="phone_number" pattern="[0-9]{12}" required/>
            <br/>
            *In what vehicle will student drive? / Lector prefer:<br>
    <?php
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
                <input type="radio" id="active" name="if_activ" value="activ">
                <label for="active">Active</label>
                <input type="radio" id="passiv" name="if_activ" value="passiv">
                <label for="passiv">Passive</label>
            </div>
            <input type="submit" value="Registry person">
        </form>
    </div>
</html>

<?php
/*
change log
    4.2 solve if person already exist //must try it
*/
if (isset($_POST["posicion"]))
{ 
    if ($_POST["posicion"] == "student") // add person
    {
        // add record to student_course_lec
        if ($_POST["type_veh"] == null) echo "<script>document.getElementById('logs').innerHTML = 'You forgot write vehicle type!'</script>";
        else if ($_POST["choose_lec"] == null) echo "<script>document.getElementById('logs').innerHTML = 'You forgot choose lector!'</script>";
        else 
        {
            if ($x=mysqli_fetch_assoc(mysqli_query($con, "SELECT * from student where email = '".$_POST["email"]."'")))
            {
                echo "<script>document.getElementById('logs').innerHTML = 'This student already exists!'</script>";
            }
            else
            {
                data_to_db($con, "insert into student(name, surname, email, phone_number, verify_student) values('" .$_POST["name"]. "','" .$_POST["surname"]. "','" .$_POST["email"]. "','" .$_POST["phone_number"]. "', '" .rand(100000, 999999). "')");
                data_to_db($con, "insert into student_course_lec(student_id, course_id, lector_id) values('" .$con->insert_id. "','" .$_POST["type_veh"]. "','" .$_POST["choose_lec"]. "')");
            }
        }
    }
    else
    {
        if ($_POST["if_activ"]==NULL)
        {
            echo "<script>document.getElementById('logs').innerHTML = 'You forgot write if he is active or passiv!'</script>";
            return 0;
        }
        else if (mysqli_fetch_assoc(mysqli_query($con, "SELECT * from lector where email = '".$_POST["email"]."'")))
        {
            echo "<script>document.getElementById('logs').innerHTML = 'This ".$_POST["posicion"]." already exists!'</script>";

        }
        else data_to_db($con, "insert into lector(name, surname, email, phone_number, prefer_veh, possicion, verify_lector, active_lec) values('" .$_POST["name"]. "', '" .$_POST["surname"]. "','" .$_POST["email"]. "','" .$_POST["phone_number"]. "','" .$_POST["type_veh"]. "','" .$_POST["posicion"]. "', " .rand(100000, 999999). ", '" .$_POST["if_activ"]. "')");
    }
    //mail("ode2@seznam.cz", "You were log in in driving school", "You were log in in driving school. Your verifycation code is: " .rand(100000, 999999). ".");
    // last if delte if
    //send email with verificational password // current net working
}










?>