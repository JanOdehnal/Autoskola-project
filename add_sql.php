<?php         
const BR="<br>";
include 'jump_wid.html';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];

    // Display the submitted data
    echo "Name: " . $email . "<br>";
    //echo "<script>change_color();</script>"; //thrre must be script
}
echo "Name: " . $_POST["add_person"] . "<br>";
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
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root";
$dbname="mydb";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

if ($_POST)
{
    echo "ok";
    if ($_POST["add_person"] == "add_person")//solve id!!!!! rewrite all sql
    { 
        if ($_POST["posicion"] == "student") $sql = "insert into student(name, surname, email, phone_number, type_car) values('" .$_POST["name"]. "', '" .$_POST["surname"]. "','" .$_POST["email"]. "','" .$_POST["phone_number"]. "','" .$_POST["type_car"]. "')";
        if ($_POST["posicion"] == "lector") $sql = "insert into lectors(name, surname, email, phone_number, possicion) values('" .$_POST["name"]. "', '" .$_POST["surname"]. "','" .$_POST["email"]. "','" .$_POST["phone_number"]. "','lector')";
        else $sql = "insert into lectors(name, surname, email, phone_number, possicion) values('" .$_POST["name"]. "', '" .$_POST["surname"]. "','" .$_POST["email"]. "','" .$_POST["phone_number"]. "','admin')";
    }
}
/*
$query = "select * from ";

if ($stmt = $con->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($field1, $field2);
    while ($stmt->fetch()) {
        //printf("%s, %s\n", $field1, $field2);
    }
    $stmt->close();
}*/









//$sql = "insert lectors(id, email, password) values(5,'".$_POST["email"]."', '".$_POST["password"]."')";





if (mysqli_query($con, $sql)) {
    $last_id = mysqli_insert_id($con);
    echo "alert('New record created successfully.')";
  } else {
    echo '<script>alert("Error: ' .$sql. '<br>' . mysqli_error($con). '")</script>';
  }
$con->close();
?>
