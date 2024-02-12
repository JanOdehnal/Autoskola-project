<html>
    <div id="add_veh" style="visibility: visible;">
        <h1>Add vehicle</h1>
        <form method="post">
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
            </select><br>
            <input type="submit" value="Delete vehicle">
        </form>
    </div>
</html>



<?php
if (isset($_POST["veh_name"])) //add vehicle
{
    data_to_db($con, "insert into course(vehicle_type, num_of_less) values ('" .$_POST["veh_name"]. "', " .$_POST["num_less"].")");
}

if (isset($_POST["del_vehicle"])) //delete vehicle
{
    data_to_db($con, "UPDATE course SET visibility = 'false' WHERE (id = " .$_POST["del_vehicle"]. ")");
}
?>