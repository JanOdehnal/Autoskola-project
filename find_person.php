<html>
<div>
    <h2>Filterable Table</h2>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <table>
    <br>
        <?php

$sql_stat = mysqli_query(connect_mysqli(), "SELECT * from lector");
$filter="";
foreach ($row = mysqli_fetch_assoc($sql_stat))
{
    $filter=$filter."<tr>";
    foreach ($cell = array_keys($row))
    {
        $filter="<td>".$cell."</td>";
    }
    $filter=$filter."</tr>";
}

$sql_stat = mysqli_query(connect_mysqli(), "SELECT * from student");
foreach ($row = mysqli_fetch_assoc($sql_stat))
{
    $filter=$filter."<tr>";
    foreach ($cell = array_keys($row))
    {
        $filter="<td>".$cell."</td>";
    }
    $filter=$filter."</tr>";
}


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

