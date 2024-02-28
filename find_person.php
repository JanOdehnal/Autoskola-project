<html>
<div id="find_person" class="jump_div">
    <h2>Najdi osobu</h2>
    <script src="jquerry.js"></script>
    <label for="myInput">Hledej:</label>
    <input class="form-control" id="myInput" type="text" placeholder="Hledej..">
    <br>
    <label for="founded">Vybrané id:</label>
    <input type="text" name="founded" id="founded" placeholder="Kliknutím vybereš">
    <br>
    <button onclick="continue_(0)">Dokončení registrace</button>
    <br>
    <button onclick="continue_(1)">Přidat hodinu studentu</button>
    <br>
    <button onclick="continue_(2)">Smazat studenta</button>
    <br>
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
    <button onclick="change_visibility('find_person', false)">Zpět</button>
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
    document.getElementById("del_add").innerHTML="Přidat osobu";
  }
  if (inf == 2)
  {
    document.getElementById("add_delete").style.visibility="visible";
    document.getElementById("delete_pers").style.visibility="visible";
    document.getElementById("del_add").innerHTML="Smazat osobu";
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

