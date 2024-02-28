<?php

function connect_mysqli()
{
    $host="localhost";
    $port=3306;
    $socket="";
    $user="root";
    $password="root";
    $dbname="drive_sch_db";
    
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Chyba v připojiní sercru!' . mysqli_connect_error());
    return $con;
}

function data_to_db($con, $sql)
{
    if (mysqli_query($con, $sql))
    {
        echo '<script>alert("New record proccesed successfully.'.$sql.'")</script>';
    }
    else echo '<script>alert("Error: ' .$sql. '\n' . mysqli_error($con). '")</script>';
}     
?>