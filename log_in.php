<html>
    <div id="log_sign" style="visibility: visible;">
        <h1 onclick="change_visibility('sign'), change_visibility('log_sign')">Sign in</h1>
        <h1 onclick="change_visibility('log'), change_visibility('log_sign')">Log in</h1>
    </div>


    <div id="sign" class="jump_div">
        <h2>Sign in</h2>
        <form method="post">
            <label for="email_s">*Email:</label>
            <input id="email_s" type="email" name="email_s" required/>
            <br>
            <label for="password_s">*Password:</label>
            <input id="password_s" type="password" name="password_s" required/>
            <br>
            <input type="submit" value="Sign in" >
        </form>
        <button onclick="change_visibility('sign'), change_visibility('log_sign')">Back</button>
    </div>


    <div id="log" class="jump_div">
        <h2>Sign in</h2>
        <form method="post">
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
            <input type="submit" value="Log in">
        </form>
        <button onclick="change_visibility('log'), change_visibility('log_sign')">Back</button>
    </div>
</html>

<?php
if (isset($_POST["email_s"]))
{
    $sql = "SELECT * from student where email = '".$_POST["email_s"]."'";
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
        if ($_POST["password_s"] == $row["password"])
        {
            $_SESSION["info"] = $row;
        }
        else
        {
            echo "<script>document.getElementById('logs').innerHTML = 'You write incorrect password!'</script>";
            session_unset();
        }
    }
    else
    {
        echo "<script>document.getElementById('logs').innerHTML = 'You write wrong email!'</script>";
        session_unset();
    }
}


if (isset($_POST["email_l"]))
{
    if ($_POST["password_l"] != $_POST["password_ag"])
    {
        echo "<script>document.getElementById('logs').innerHTML = 'You write not write passwords same!'</script>";
        return 0;
    }
    $sql = "SELECT * from student where email = '".$_POST["email_l"]."'";
    $sql_row = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($sql_row))
    {
        if($row["password"] != null)
        {
            echo "<script>document.getElementById('logs').innerHTML = 'You are already logged in!'</script>";
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
                echo "<script>document.getElementById('logs').innerHTML = 'You are already logged in!'</script>";
                return 0;
            }
            else if ($row["verify_pass"] == $_POST["password_ver"])
            {
                $_SESSION["possicion"] = "lector";
                $_SESSION["info"] = $row;
                data_to_db($con, "UPDATE lector SET password = '" .$_POST["password_l"]. "' where email = '" .$_POST["email_l"]. "'");
            }
            else
            {
                echo "<script>document.getElementById('logs').innerHTML = 'You write incorrect veryfication password!'</script>";
            }
        }
        else
        {
            echo "<script>document.getElementById('logs').innerHTML = 'You write wrong email!'</script>";
            return 0;
        }
    }
}






?>