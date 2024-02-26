<script src="javascript.js"></script>
<?php
if (!(isset($_SESSION["possicion"]) && $_SESSION["possicion"]=="lector" && $_SESSION["info"]["possicion"]!="admin"))
{
    require_once "navigation.php";
}



require_once "connect_mysqli.php";
?>
<html>
    <div id="add_person_1">
        <h1>Add new person</h1>
        <form method="POST">
            *Choode who it is:<br>
            <input type="radio" id="student" name="posicion" value="student" required>
            <label for="student">Student</label>
            <input type="radio" id="lector" name="posicion" value="lector">
            <label for="lector">Lector</label>
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
            <br>
            <input type="submit" value="registry">
        </form>
    </div>        
</html>

<?php
$con=connect_mysqli();
if (isset($_SESSION["possicion"]) && $_SESSION["possicion"]=="lector" && $_SESSION["info"]["possicion"] == "admin") require_once "add_person_2.php";
else echo "!!!!!!!!!!!!!!!!!!!!!!!". $_SESSION["info"]["possicion"].'?????';
if (isset($_POST["posicion"]))
{
    if (mysqli_fetch_assoc(mysqli_query($con, "SELECT * from lector where email = '".$_POST["email"]."'")))
    {
        echo '<script>alert("This person already exist!")</script>';
        return 0;
    }
    if (mysqli_fetch_assoc(mysqli_query($con, "SELECT * from student where email = '".$_POST["email"]."'")))
    {
        echo '<script>alert("This person already exist!")</script>';
        return 0;
    }
    data_to_db($con,"INSERT into ".$_POST["posicion"]."(name, surname, email, phone_number) values('" .$_POST["name"]. "','" .$_POST["surname"]. "','" .$_POST["email"]. "','" .$_POST["phone_number"]. "')");
    //send email
    if (isset($_SESSION["possicion"]) && $_SESSION["possicion"]=="lector" && $_SESSION["info"]["possicion"] == "admin") echo "<script>window.onload(reg('".$_POST["posicion"]."', ".$con->insert_id."))</script>";
}
?>