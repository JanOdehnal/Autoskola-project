<html>
<h1 onclick="change_visibility('hours')">wiev your hours</h1>
<div class="jump_div" id="hours">
    <table>
        <tr>
            <td>date</td>
            <td>lesson</td>
            <td>lesson finish</td>
        </tr>
</html>
<?php
$les_tab = "";
$count=0;

$sql_stat = mysqli_query(connect_mysqli(), "SELECT lesson_date, lesson_num, finish_lesson  from timetable where student_id = ".$_SESSION["info"]["id"]." order by lesson_date, lesson_num");
while ($row = mysqli_fetch_assoc($sql_stat))
{
    $count+=1;
    $les_tab = $les_tab."<tr>";
    foreach (array_values($row) as $cell)//play?
    {
        $les_tab = $les_tab."<td>".$cell."</td>";
    }
    $les_tab = $les_tab."</tr>";
}
$les_tab = $les_tab."</table>number of all hours : ".$count."<br><button onclick=\"change_visibility('hours')\">hide</button></div>";
echo $les_tab;











?>