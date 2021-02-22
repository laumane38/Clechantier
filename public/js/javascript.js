
$(document).ready(function() {
    $('.js-datepickerStart').datepicker({

        format: 'dd/mm/yy'
    });

    $('.js-datepickerEnd').datepicker({
        format: 'dd/mm/yy'
    });
});

if (document.getElementById('lunettesI')) {
    idsend = 'inscription_password';
    idreceived = document.getElementById('lunettesI');
}

if (document.getElementById('lunettesC')) {
    idsend = 'connexion_password';
    idreceived = document.getElementById('lunettesC');
}

if (document.getElementById('lunettesM')) {
    idsend = 'password_modify_password';
    idreceived = document.getElementById('lunettesM');
}

idreceived.addEventListener('click', glasses);

function glasses() {
    if (document.getElementById(idsend).type == 'text') {
        document.getElementById(idsend).type = 'password';
    } else {
        document.getElementById(idsend).type = 'text';
    }
}

function changeAvatar(val) {
    document.getElementById('avatar_avatar').value = val;
    document.getElementById('avatar_button').style.visibility = 'visible';
}

 