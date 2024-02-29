
<html>
    <div id="log_out_div">
        <h1>Odhlásit se</h1>
        <form method="post"> 
            <input type="submit" name="logg_out" value="Odhlásit se!">
        </form>
    </div>
</html>

<?php

if (isset($_POST["logg_out"]))
{
    session_unset(); 
}
?>