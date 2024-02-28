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

function add_hours(num)
{
    document.getElementById("hour_num").value = num;
}

function reg(pos, id)
{
    document.getElementById("add_person_2").style.visibility = "visible";
    document.getElementById("add_person_1_").style.visibility = "hidden";
    document.getElementById("reg_").value = id;
    if (pos == 'student')
    {
        document.getElementById("reg").value = "student";
        change_visibility('if_student', true);
        change_visibility('active_lec', false);
    }
    else
    {
        document.getElementById("reg").value = "lector";
        change_visibility('active_lec', true);
        change_visibility('if_student', false);
    }
}