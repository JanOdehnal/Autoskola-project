<script src="javascript.js"></script>

<?php
    //constants
    const BR="<br>";


    $host="localhost";
    $port=3306;
    $socket="";
    $user="root";
    $password="root";
    $dbname="drive_sch_db";

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());

    //$con->close();

    //record to db
    function data_to_db($con, $sql)
    {
        if (mysqli_query($con, $sql))
        {
            echo '<script>alert("New record proccesed successfully.'.$sql.'")</script>';
        }
        else echo '<script>alert("Error: ' .$sql. '\n' . mysqli_error($con). '")</script>';
    }

    //processing data
    if ($_POST)
    {    
        if (isset($_POST["add_person"]))
        { 
            if ($_POST["posicion"] == "student") // add person
            {
                // add record to student_course_lec
                if ($_POST["type_veh"] == null) echo "<script>alert('You not choose vehicle type!')</script>";
                else if ($_POST["choose_lec"] == null) echo "<script>alert('You not choose lector!')</script>";
                else 
                {
                    data_to_db($con, "insert into student(name, surname, email, phone_number, verify_strudent) values('" .$_POST["name"]. "','" .$_POST["surname"]. "','" .$_POST["email"]. "','" .$_POST["phone_number"]. "', '" .rand(100000, 999999). ")");
                    data_to_db($con, "insert into student_course_lec(student_id, course_id, lector_id) values('" .$con->insert_id. "','" .$_POST["type_veh"]. "','" .$_POST["choose_lec"]. "')");
                }
            }
            else if ($_POST["posicion"] == "lector") data_to_db($con, "insert into lector(name, surname, email, phone_number, prefer_veh, possicion, verify_lector) values('" .$_POST["name"]. "', '" .$_POST["surname"]. "','" .$_POST["email"]. "','" .$_POST["phone_number"]. "','" .$_POST["type_veh"]. "','lector', " .rand(100000, 999999). ")");
            else if ($_POST["posicion"] == "admin") data_to_db($con, "insert into lector(name, surname, email, phone_number, prefer_veh, possicion, verify_lector) values('" .$_POST["name"]. "', '" .$_POST["surname"]. "','" .$_POST["email"]. "','" .$_POST["phone_number"]. "','" .$_POST["type_veh"]. "','admin', " .rand(100000, 999999). ")");
            //mail("ode2@seznam.cz", "You were log in in driving school", "You were log in in driving school. Your verifycation code is: " .rand(100000, 999999). ".");
            // last if delte if
            //send email with verificational password // current net working
        }
        else if (isset($_POST["sign_in"])) //sign in // vyzkouset
        {
            $correct_pass=true;
            $tmp = true;  
            if ($_POST["posicion_s"] == "student") $query = "select email, password from student";
            else $query = "select email, password, possicion from lector";
            if ($stmt = $con->prepare($query))
            {
                $correct = false;
                $stmt->execute();
                if ($_POST["posicion_s"] == "student")
                {
                    $stmt->bind_result($email, $password);
                }
                else
                {
                    $stmt->bind_result($email, $password, $possicion);
                    $tmp = false;
                }
                while ($stmt->fetch())
                {
                    if ($_POST["email_s"] == $email) 
                    {
                        if ($_POST["password_s"] != $password) 
                        {
                            echo "<script>alert('You write wrong password!')</script>";
                            $correct_pass=false;
                            break;
                        }
                        else
                        {
                            if ($tmp == false) $pos = $possicion;
                            $correct = true;
                            break;
                        }
                    }
                }
                $stmt->close();
                if ($correct)
                {
                    $number = rand(100000, 999999);
                    if ($tmp)
                    {
                        data_to_db($con, "UPDATE student SET verify_student = '" .$number. "' where email = '" .$_POST["email_s"]. "'");
                        echo ("<script>window.onload = function(){add_values('student', '" .$_POST["email_s"]. "');}</script>");
                        //email($_POST["email_l"], "werify passvord", "We are sending you a verifycation password: " .$number. ".");
                    }
                    else
                    {
                        data_to_db($con, "UPDATE lector SET verify_lector = '" .$number. "' where email = '" .$_POST["email_s"]. "'");
                        echo ("<script>window.onload = function(){add_values('" .$pos. "', '" .$_POST["email_s"]. "');}</script>");//nefunguje !!!!!!!!!!!!!!                        
                    }
                    //email($_POST["email_l"], "werify passvord", "We are sending you a verifycation password: " .$number. ".");
                }
                else if ($correct_pass) echo "<script>alert('Wrong email!')</script>";
            }   
        }
        else if (isset($_POST["log_in"])) //log in
        {    
            if ($_POST["password_l"] != $_POST["password_ag"]) echo "<script>alert('Your own passwords are not same ')</script>";
            {
                $tmp=true;
                if ($_POST["posicion_l"] == "student") $query = "select id, email, password, verify_student from student";
                else
                {
                    $query = "select id, email, password, verify_lector, possicion from lector";
                    $tmp=false;
                }
                if ($stmt = $con->prepare($query))
                {
                    $correct = false;
                    $tmp_pos="";
                    $stmt->execute();
                    if ($tmp) $stmt->bind_result($id, $email, $password, $verify);
                    else $stmt->bind_result($id, $email, $password, $verify, $possicion);
                    while ($stmt->fetch())
                    {
                        if ($_POST["email_l"] == $email) 
                        {
                            if ($password != null) echo "<script>alert('You are already logged in!')</script>";
                            else if ($_POST["password_ver"] != $verify) echo "<script>alert('Wrong verifycation password!')</script>";
                            else
                            {
                                if (!$tmp)$tmp_pos = $possicion;
                                $correct = true;
                                break;
                            }
                        }
                    }
                    $stmt->close();
                    if ($correct)
                    {
                        if ($tmp) 
                        {
                            data_to_db($con, "UPDATE student SET password = '" .$_POST["password_l"]. "' where email = '" .$_POST["email_l"]. "'");
                            header("Location:http://localhost//Honza/autoskola_priprava/student.php");
                        }
                        else
                        {
                            data_to_db($con, "UPDATE lector SET password = '" .$_POST["password_l"]. "' where email = '" .$_POST["email_l"]. "'");
                            if ($tmp_pos == "lector") header("Location:http://localhost//Honza/autoskola_priprava/lector.php");
                            else header("Location:http://localhost//Honza/autoskola_priprava/admin.php");

                        }

                    }
                    else echo "<script>alert('Wrong email!')</script>";
                }    
            }
        } 
        else if (isset($_POST["add_veh"])) //add vehicle
        {
            data_to_db($con, "insert into course(vehicle_type, num_of_less) values ('" .$_POST["veh_name"]. "', " .$_POST["num_less"].")");
        }
        else if (isset($_POST["del_veh"])) //delete vehicle
        {
            data_to_db($con, "DELETE FROM course WHERE id=".$_POST["del_vehicle"]);
        }
        else if (isset($_POST["verify_password"])) //verify password
        {
            if ($_POST["pos"] == "student") $query = "select email, verify_student from student";
            else $query = "select email, verify_lector from lector";
            if ($stmt = $con->prepare($query))
            {
                $stmt->execute();
                echo ("<script>console.log('".$_POST["person_em"]."')</script>");
                $stmt->bind_result($email, $password);
                while ($stmt->fetch())
                {
                    if ($_POST["person_em"] == $email)
                    {
                        if ($_POST["ver_pass"] == $password)
                        {
                            echo "<script>alert('You are sign in!')</script>";
                            if ($_POST["pos"] == "student") header("Location:http://localhost//Honza/autoskola_priprava/student.php");
                            else if ($_POST["person_em"] == "lector") header("Location:http://localhost//Honza/autoskola_priprava/lector.php");
                            else header("Location:http://localhost//Honza/autoskola_priprava/admin.php");
                        }
                        else echo "<script>alert('Wrong verifycation password!')</script>";
                    }
                }
                $stmt->close();
            }
        }
        else if (isset($_POST["add_side"]))
        {
            data_to_db($con, "insert into sides(town, street, GPS_coordinate, more_info) values ('" .$_POST["town"]. "', '" .$_POST["street"]."', '".$_POST["jps"]."', '".$_POST["info"]."')");
        }
        else if (isset($_POST["del_s"]))
        {
            data_to_db($con, "DELETE FROM sides WHERE id=".$_POST["mod_side"]);
        }
    }


/*
echo "formular odeslan".BR;
echo "email:".$_POST["email"].BR;
echo "heslo:".$_POST["password"].BR.BR;*/
//setcookie($_POST["email"], $_POST["password"], time() + (86400 * 30), "/"); // 86400 = 1 day

/*if(!isset($_COOKIE[$_POST["email"]])) {
    echo "Cookie email '" . $_POST["email"] . "' is not set!";
} else {
  echo "Cookie '" . $_POST["email"] . "' is set!<br>";
  //echo "Value is: " . $_COOKIE[$cookie_name];
}*/
// TODO - sestavime SQL INSERT into uzivatele...
//$sql = "insert into uzivatele(id, email, password, telefon)"."values(4'".$_POST["email"]."', '".$_POST["password"]."')";

//echo $sql.BR;
//include 'connect_sql+const.php';
?>