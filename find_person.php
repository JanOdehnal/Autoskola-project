<html>
<div>
    <h2>Filterable Table</h2>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <table id="myTable">
    <br>
<?php
include_once "connect_mysqli.php";
//$sql_stat = mysqli_query(connect_mysqli(), "SELECT * from lector");
$filter = "";
$sql_field = ["lector", "student", "sides", "course"];
foreach (array_values($sql_field) as $sql_and)
{
    $sql_stat = mysqli_query(connect_mysqli(), "SELECT * from ".$sql_and);
    while ($row = mysqli_fetch_assoc($sql_stat))
    {
        $filter=$filter."<tr>";
        foreach (array_values($row) as $cell)
        {
            //if ($sql_and == "student" && $cell == 1) break;
            $filter=$filter."<td>".$cell."</td>";
        }
        $filter=$filter."</tr>";
    }
}

echo $filter;

?>
        </table>
</div>
</html>

<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

