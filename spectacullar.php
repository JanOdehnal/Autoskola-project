<?php include 'connect_mysql.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
            <input type="submit" value="Sign in" >
            <!--<button onclick="not_in_php()"></button>-->
        </form>
        <button onclick="change_visibility('sign'), change_visibility('log_sign')">Back</button>
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
            <input type="submit" value="Log in">
        </form>
        <button onclick="change_visibility('log'), change_visibility('log_sign')">Back</button>
    </div>


    <div id="verify_pass" style="visibility: hidden;">
        <h1>Verify password</h1>
        <form method="post">
            <input type="hidden" id="verify_password" name="verify_password" value="verify_password">
            <input type="hidden" id="pos" name="pos" value="">
            <input type="hidden" id="person_em" name="person_em" value="">
            <label for="ver_pass">*Werifycation password:</label>
            <input id="ver_pass" type="password" name="ver_pass" required/>
            <br>
            <input type="submit" value="Send">
        </form>
    </div>

</body>
</html>