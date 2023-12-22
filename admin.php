<?php include 'connect_mysql.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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


</body>
</html>