<?php

/*class Hour
{
    $start;
    $duration;
    function set_start($time)
    {
        $this->$start=$time;
    }
}

class timetable
{
    
}*/
function get_last_Monday()
{
    $ls_mon=time();
    date("w", $ls_mon);
    for ($i = 0; $i < 7; $i++)
    {
        if (date("w", $ls_mon-24*3600*$i) == 1)
        {
            echo $i."<br>";
            return $ls_mon-24*3600*$i;
        }
    }
}

echo date("w", get_last_Monday());
function get_date($sec_day)
{
    $days=["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Satusday"];
    return $days[date("w", $sec_day)];
}

function create_table()
{
    $tmp=0;
    $last_Mo=get_last_Monday();
    $table = "<table border='1px solid black'>";
    $table=$table."<tr>";
    for ($j = 0; $j < 8; $j++)
    {
        if ($j==0) $table=$table."<td></td>";
        else $table=$table."<td>time</td>";
    }
    $table=$table."</tr>";
    for ($i = 0; $i < 7; $i++)
    {
        $table=$table."<tr>";
        for ($j = 0; $j < 8; $j++)
        {
            $tmp=$last_Mo+24*3600*$i;
            if ($j==0) $table=$table."<td>".date("d-m-Y", $tmp).", ".get_date($tmp)."</td>";
            else $table=$table."<td>some text</td>";
        }
        $table=$table."</tr>";
    }
    $table=$table."</table>";
    echo $table;
}
create_table();














?>