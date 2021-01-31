
if (document.getElementById('lunettesI') || document.getElementById('lunettesC')) {

    if (document.getElementById('lunettesI')) {
        idsend = 'inscription_password';
        idreceived = document.getElementById('lunettesI');
    }

    if (document.getElementById('lunettesC')) {
        idsend = 'connexion_password';
        idreceived = document.getElementById('lunettesC');
    }

    idreceived.addEventListener('click', glasses);

    function glasses() {
        if (document.getElementById(idsend).type == 'text') {
            document.getElementById(idsend).type = 'password';
        } else {
            document.getElementById(idsend).type = 'text';
        }
    }
}


if (document.getElementById('adress_zipCode')) {

    idreceived = document.getElementById('adress_zipCode');
    idsend = document.getElementById('adress_city');
    value = document.getElementById('adress_zipCode').value;
    idreceived.addEventListener('blur', ajaxZipCode);

    ajaxZipCode(value, idreceived, idsend);



    function ajaxZipCode(val, hote, cible) {
        $.ajax({
            url: "ajax",
            type: "POST",
            dataType: "json",
            data: hote + '=' + val,
            success: function (data) {
                $("#" + cible).html(data);
            },
            error: function (error) {
                console.log("Error:");
                console.log(error);
            }
        });
    }
}

function changeAvatar(val) {
    document.getElementById('avatar_avatar').value = val;
    document.getElementById('avatar_button').style.visibility = 'visible';
}
