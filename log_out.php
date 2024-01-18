
<html>
    <div id="log_out_div">
        <h1>Logg out</h1>
        <form method="post"> 
            <input type="submit" name="logg_out" value="Logg out">
        </form>
    </div>
</html>

<?php

if (isset($_POST["logg_out"]))
{
    session_unset(); 
}
?>