<script src="javascript.js"></script>
<?php include 'php_func.php';?>




<div id="add_person_form">
    <h1>Add new person</h1>
    <form method="POST"><!--who is it-->
        <input type="hidden" id="add_person" name="add_person" value="add_person">
        *Choode who it is:<br>
        <input type="radio" id="student" name="posicion" value="student" onclick="change_visibility('if_student', true)" required>
        <label for="student">Student</label>
        <input type="radio" id="lector" name="posicion" value="lector" onclick="change_visibility('if_student', false)">
        <label for="lector">Lector</label>
        <input type="radio" id="admin" name="posicion" value="admin" onclick="change_visibility('if_student', false)">
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
    $query = "select id, vehicle_type, num_of_less from course";
    if ($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($id, $vehicle, $lesson_num);
        while ($stmt->fetch()) {
            echo '<input type="radio" id="'. $vehicle .'" name="type_veh" value="'. $id .'">
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
    
    $query = "select id, name, surname, email from lector";
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
        </div>
        <input type="submit" value="Registry person">
    </form>
</div>



<div id="log_sign" style="visibility: visible;">
    <h1 onclick="change_visibility('sign'), change_visibility('log_sign')">Sign in</h1>
    <h1 onclick="change_visibility('log'), change_visibility('log_sign')">Log in</h1>
</div>


<div id="sign" style="visibility: hidden;">
    <h2>Sign in</h2>
    <form method="post">
        <input type="hidden" id="sign_in" name="sign_in" value="sign_in">
        <input type="radio" id="student_s" name="posicion_s" value="student" required>
        <label for="student_s">Student</label>
        <input type="radio" id="lector_s" name="posicion_s" value="lector">
        <label for="lector_s">Lector/Admin</label>
        <br>
        <label for="email">*Email:</label>
        <input id="email_s" type="email" name="email_s" required/>
        <br>
        <label for="password_s">*Password:</label>
        <input id="password_s" type="password" name="password_s" required/>
        <br>
        <button onclick="change_visibility('sign'), change_visibility('log_sign')">Back</button>
        <input type="submit" value="Sign in" >
    </form>
</div>


<div id="log" style="visibility: hidden;">
    <h2>Log in</h2>
    <form method="post">
        <input type="hidden" id="log_in" name="log_in" value="log_in">
        <input type="radio" id="student_l" name="posicion_l" value="student" required>
        <label for="student_l">Student</label>
        <input type="radio" id="lector_l" name="posicion_l" value="lector">
        <label for="lector_l">Lector/Admin</label>
        <br>
        <label for="email_l">*Email:</label>
        <input id="email_l" type="email" name="email_l" required/>
        <br>
        <label for="password_l">*Set password</label>
        <input id="password_l" type="password" name="password_l" required/>
        <br>
        <label for="password_ag">*Write password again:</label>
        <input id="password_ag" type="password" name="password_ag" required/>
        <br>
        <label for="password_ver">*Werication password:</label>
        <input id="password_ver" type="password" name="password_ver" required/>
        <br>
        <button onclick="change_visibility('log'), change_visibility('log_sign')">Back</button>
        <input type="submit" value="Log in">
    </form>
</div>


<div id="add_veh" style="visibility: visible;">
    <h1>Add vehicle</h1>
    <form method="post">
        <input type="hidden" id="add_veh" name="add_veh" value="add_veh">
        <label for="veh_name">*Vehicle name:</label>
        <input id="veh_name" type="text" name="veh_name" required/>
        <br>
        <label for="num_less">*Number of compursory lessons:</label>
        <input id="num_less" type="number" name="num_less" min="0" required>
        <br>
        <input type="submit" value="Add vehicle">
    </form>
</div>


<div id="del_veh" style="visibility: visible;">
    <h1>Delete vehicle</h1>
    <form method="post">
        <input type="hidden" id="del_veh" name="del_veh" value="del_veh">
        <label for="del_vehicle">Delete vehicle: </label>
        <select name="del_vehicle" id="del_vehicle" require>
        
<?php
    $query = "select id, vehicle_type from course";
    if ($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($id, $vehicle);
        while ($stmt->fetch()) {
            echo '<option value="' . $id . '">' .$vehicle. '</option>';
        }
        $stmt->close();
    }
?>
        </select><br>
        <input type="submit" value="Delete vehicle">
    </form>
</div>


<div id="verify_pass" style="visibility: visible;">
    <h1>Verify password</h1>
    <form method="post">
        <input type="hidden" id="verify_password" name="verify_password" value="verify_password">
        <input type="hidden" id="pos" name="pos" value="lector">
        <input type="hidden" id="person_em" name="person_em" value="jan@pako">
        <label for="ver_pass">*Werifycation password:</label>
        <input id="ver_pass" type="password" name="ver_pass" required/>
        <br>
        <input type="submit" value="Send">
    </form>
</div>


<div id="add_side" style="visibility: visible;">
    <h1>Add side</h1>
    <form method="post">
        <input type="hidden" id="add_side" name="add_side" value="add_side">
        <label for="town">Town name:</label>
        <input type="text" id="town" name="town">
        <br>
        <label for="street">Street name:</label>
        <input type="text" id="street" name="street">
        <br>
        <label for="jps">Jps coodinates:</label>
        <input type="text" id="jps" name="jps">
        <br>
        <label for="info">More info:</label>
        <input type="text" id="info" name="info">
        <br>
        <input type="submit" value="Send">
    </form>
</div>


<div id="del_side" style="visibility: visible;">
    <h1>Delete side</h1>
    <form method="post">
        <input type="hidden" id="del_s" name="del_s" value="del_s">
        <label for="mod_side">Delete side: </label>
        <select name="mod_side" id="mod_side" require>       
<?php
    $query = "select id, town, street, GPS_coordinate, more_info from sides";
    if ($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($id, $town, $street, $GPS_coordinate, $more_info);
        while ($stmt->fetch()) {
            echo '<option value="' . $id . '">' .$town. ', ' .$street. ', ' .$GPS_coordinate. ', ' .$more_info. '</option>';
        }
        $stmt->close();
    }
?>
        </select>
        <br>
        <input type="submit" value="Delete side">
    </form>
</div>


<div>
    <h1>Engage lesson</h1>
    <form method="post">
        <input type="hidden" id="engage_les" name="engage_les" value="engage_les">
        <label for="meet_side">Choose where we meet:</label>
        <select name="meet_side" id="meet_side" require>       
<?php
    $query = "select id, town, street, GPS_coordinate, more_info from sides";
    if ($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($id, $town, $street, $GPS_coordinate, $more_info);
        while ($stmt->fetch()) {
            echo '<option value="' . $id . '">' .$town. ', ' .$street. ', ' .$GPS_coordinate. ', ' .$more_info. '</option>';
        }
        $stmt->close();
    }
?>
        </select>
        <br>
        <label for="message">Write some message:</label>
        <input type="text" id="message" name="message">
        <br>
        <input type="submit" value="send">
    </form>

</div>
