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
    //console.log('proslo!!!!!!'+possicion+" "+ email+"and");

    change_visibility("verify_pass");
    document.getElementById("pos").value = possicion;
    document.getElementById("pers_em").value = email;
}


