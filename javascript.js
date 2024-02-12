function change_color()
{
    document.getElementById("jum_d").style.background="red";
}

function change_visibility(id, vis = null)
{
    if (vis == null)
    {
        if (document.getElementById(id).style.visibility == "visible") document.getElementById(id).style.visibility = "hidden";
        else document.getElementById(id).style.visibility = "visible";
    }
    else if (vis == false) document.getElementById(id).style.visibility = "hidden";
    else document.getElementById(id).style.visibility = "visible";
}

function add_values(possicion, email)
{
    change_visibility("verify_pass");
    document.getElementById("pos").value = possicion;
    document.getElementById("person_em").value = email;
}

function engage_less(lector, pos_hour, date, back)
{
    //console.log(lector+"___"+pos_hour+"__"+date);
    if (back)
    {
        document.getElementById("h1_eng").innerHTML = "Sign off lesson";
        document.getElementById("sign_off").value = back;


    }
    document.getElementById("meet_add").style.visibility = "visible";
    document.getElementById("start_date").innerHTML =  date;
    let d = String(date);
    d=d.split(".");
    document.getElementById("start_date_").value =  d[2]+"-"+d[1]+"-"+d[0];
    document.getElementById("start_hour").innerHTML =  document.getElementById(lector+"_0_"+pos_hour).innerHTML;
    document.getElementById("start_hour_").value =  pos_hour;
    document.getElementById("lector_name").innerHTML =  document.getElementById(lector+"_lec").innerHTML;
    document.getElementById("lector_name_").value =  lector;
}

function add_hours(num)
{
    document.getElementById("hour_num").value = num;
}