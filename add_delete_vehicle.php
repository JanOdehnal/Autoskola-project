<html>
    <div id="add_veh" class="jump_div">
        <h1>přidej kurz</h1>
        <form method="post">
            <label for="vehic_name">*Název:</label>
            <input id="vehic_name" type="text" name='vehic_name' required/>
            <br>
            <label for="num_less_">*Počet povinných hodin(45 min):</label>
            <input id="num_less_" type="number" name='num_less_' min="0" required>
            <br>
            <input type="submit" value="Add vehicle">
            <br>
        <button onclick="change_visibility('add_veh', false)">Back</button>
        </form>
    </div>

    <div id="del_veh" class="jump_div">
        <h1>Zrušit kurz</h1>
        <form method="post">
            <label for="del_vehicle">Delete vehicle: </label>
            <select name="del_vehicle" id="del_vehicle" require>
            
    <?php
        $query = "select id, vehicle_type, visibility from course";
        if ($stmt = $con->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($id, $vehicle, $visibility);
            while ($stmt->fetch()) {
                if ($visibility=='true') echo '<option value="' . $id . '">' .$vehicle. '</option>';
            }
            $stmt->close();
        }
    ?>
            </select>
            <br>
            <input type="submit" value="Delete vehicle">
        </form>
        <button onclick="change_visibility('del_veh', false)">Back</button>
    </div>
</html>



<?php
if (isset($_POST["vehic_name"])) //add vehicle
{
    data_to_db($con, "insert into course(vehicle_type, num_of_less, visibility) values ('" .$_POST["vehic_name"]. "', " .$_POST["num_less_"].", 'true')");
}

if (isset($_POST["del_vehicle"])) //delete vehicle
{
    data_to_db($con, "UPDATE course SET visibility = 'false' WHERE (id = " .$_POST["del_vehicle"]. ")");
}
?>