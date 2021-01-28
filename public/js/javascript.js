let idsend;
let idreceived;

if (document.getElementById('lunettesC')) {
    idsend = 'connexion_password';
    idreceived = document.getElementById('lunettesC');
}

if (document.getElementById('lunettesI')) {
    idsend = 'inscription_password';
    idreceived = document.getElementById('lunettesI');
}

idreceived.addEventListener('click', glasses);

function glasses() {
    if (document.getElementById(idsend).type == 'text') {
        document.getElementById(idsend).type = 'password';
    } else {
        document.getElementById(idsend).type = 'text';
    }
}