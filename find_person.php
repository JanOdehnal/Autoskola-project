<html>
<div id="find_person" class="jump_div">
    <h2>Find person</h2>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>-->
    <script src="jquerry.js"></script>
    <label for="myInput">Search:</label>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <br>
    <label for="founded">This id you choose:</label>
    <input type="text" name="founded" id="founded" placeholder="Click to choose">
    <br>
    <button onclick="continue_(0)">Finish registry</button>
    <br>
    <button onclick="continue_(1)">Add lessons</button>
    <br>
    <button onclick="continue_(2)">Delete person</button>
    <br>
    <!--<button onclick="continue_(3)">Forget password</button>
    <br>-->
    <table id="myTable">
    <br>
<?php
include_once "connect_mysqli.php";
$filter = "";
$sql_field = ["lector", "student"];
foreach (array_values($sql_field) as $sql_and)
{
    $sql_stat = mysqli_query(connect_mysqli(), "SELECT * from ".$sql_and);
    while ($row = mysqli_fetch_assoc($sql_stat))
    {
        if ($sql_and == "student" && $row["id"] == 1) continue;
        $filter=$filter."<tr onclick=\"find('".$sql_and."', ".$row["id"].")\">";
        $filter=$filter."<td>".$sql_and."</td>";
        foreach (array_values($row) as $cell)
        {
            $filter=$filter."<td>".$cell."</td>";
        }
        $filter=$filter."</tr>";
    }
}

echo $filter;

?>
        </table>
    <button onclick="change_visibility('find_person', false)">Back</button>
</div>
</html>

<script>
function find(what, id)
{
  
  document.getElementById("pos_contin_p").value=what;
  document.getElementById("pos_contin_i").value=id;
  document.getElementById("founded").value= what+"_"+id;
}

function continue_(inf)
{
  if (inf == 0)
  {
    reg(document.getElementById("pos_contin_p").value, document.getElementById("pos_contin_i").value);
    return 0;
  }
  if (inf == 1)
  {
    document.getElementById("add_delete").style.visibility="visible";
    document.getElementById("add_hours").style.visibility="visible";
  }
  if (inf == 2)
  {
    document.getElementById("add_delete").style.visibility="visible";
    document.getElementById("delete_pers").style.visibility="visible";
  }
}


$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

