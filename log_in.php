<html>
    <div id="log_sign" style="visibility: visible;">
        <h1 onclick="change_visibility('sign'), change_visibility('log_sign')">Přihlásit se</h1>
        <h1 onclick="change_visibility('log'), change_visibility('log_sign')">Registrace</h1>
    </div>


    <div id="sign" class="jump_div">
        <h2>Přihlásit se</h2>
        <form method="post">
            <label for="email_s">*Email:</label>
            <input id="email_s" type="email" name="email_s" required/>
            <br>
            <label for="password_s">*Heslo:</label>
            <input id="password_s" type="password" name="password_s" required/>
            <br>
            <input type="submit" value="Přihlásit se" >
        </form>
        <button onclick="change_visibility('sign'), change_visibility('log_sign')">Zpět</button>
    </div>


    <div id="log" class="jump_div">
        <h2>Registrace</h2>
        <form method="post">
            <label for="email_l">*Email:</label>
            <input id="email_l" type="email" name="email_l" required/>
            <br>
            <label for="password_l">*Zadej heslo:</label>
            <input id="password_l" type="password" name="password_l" required/>
            <br>
            <label for="password_ag">*Zadej heslo znovu:</label>
            <input id="password_ag" type="password" name="password_ag" required/>
            <br>
            <label for="password_ver">*Zadej ověřovací heslo:</label>
            <input id="password_ver" type="password" name="password_ver" required/>
            <br>        
            <input type="submit" value="Registrace">
        </form>
        <button onclick="change_visibility('log'), change_visibility('log_sign')">Zpět</button>
    </div>
</html>

<?php
if (isset($_POST["email_s"]))
{
    $sql = "SELECT x.*, y.* from student x left join student_course_lec y on x.id = y.student_id where email = '".$_POST["email_s"]."'";
    $sql_row = mysqli_query($con, $sql);
    $_SESSION["possicion"] = "student";
    if (!$row = mysqli_fetch_assoc($sql_row))
    {
        $sql = "SELECT * from lector where email = '".$_POST["email_s"]."'";
        $sql_row = mysqli_query($con, $sql);
        $_SESSION["possicion"] = "lector";
        $row = mysqli_fetch_assoc($sql_row);
    }
    if ($row!=null)
    {
        if (md5($_POST["password_s"]) == $row["password"])
        {
            
            if ($_SESSION["possicion"] == "lector" && $row["id"] == 1 && array_values(mysqli_fetch_assoc(mysqli_query(connect_mysqli(), "SELECT count(id) from lector")))[0] > 1)
            {
                session_unset();
            }
            else $_SESSION["info"] = $row;
        }
        else
        {
            echo "<script>document.getElementById('logs').innerHTML = 'Chybné heslo!'</script>";
            session_unset();
        }
    }
    else
    {
        echo "<script>document.getElementById('logs').innerHTML = 'Chybný email!'</script>";
        session_unset();
    }
}


if (isset($_POST["email_l"]))//hash
{
    if ($_POST["password_l"] != $_POST["password_ag"])
    {
        echo "<script>document.getElementById('logs').innerHTML = 'Tvoje hesla nejsou stejná!'</script>";
        return 0;
    }
    $sql = "SELECT x.*, y.* from student x left join student_course_lec y on x.id = y.student_id where email ='".$_POST["email_l"]."'";
    $sql_row = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($sql_row))
    {
        if($row["password"] != null)
        {
            echo "<script>document.getElementById('logs').innerHTML = 'Již jsi přihlášen!'</script>";
            return 0;
        }
        else if ($row["verify_pass"] == $_POST["password_ver"])
        {
            $_SESSION["possicion"] = "student";
            $_SESSION["info"] = $row;
            data_to_db($con, "UPDATE student SET password = '" .$_POST["password_l"]. "' where email = '" .$_POST["email_l"]. "'");
        }
    }
    else
    {
        $sql = "SELECT * from lector where email = '".$_POST["email_l"]."'";
        $sql_row = mysqli_query($con, $sql);
        if ($row = mysqli_fetch_assoc($sql_row))
        {
            if($row["password"] != null)
            {
                echo "<script>document.getElementById('logs').innerHTML = 'Již jsi přihlášen!'</script>";
                return 0;
            }
            else if ($row["verify_pass"] == $_POST["password_ver"])
            {
                $_SESSION["possicion"] = "lector";
                $_SESSION["info"] = $row;
                data_to_db($con, "UPDATE lector SET password = '" .md5($_POST["password_l"]). "' where email = '" .$_POST["email_l"]. "'");
            }
            else
            {
                echo "<script>document.getElementById('logs').innerHTML = 'Špatné ověřovací heslo!'</script>";
            }
        }
        else
        {
            echo "<script>document.getElementById('logs').innerHTML = 'Zadal jsi nesprávný email!'</script>";
            return 0;
        }
    }
}






?>