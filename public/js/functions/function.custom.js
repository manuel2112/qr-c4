$(document).ready(function() {

    //INPUT SOLO NÚMEROS
    $('[type=number]').on('keypress', function(e) {
        keys = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return keys.indexOf(event.key) > -1;
    });

});

function nl2br(str) {
    if( str ){
      return str.replace(/(?:\r\n|\r|\n)/g, '<br>');
    }
    return '';
}

function validateEmail(email) {

    let boolEmail = false;
    const match = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if( email.match(match) ){
        boolEmail = true;
    }
    
    return boolEmail;
}

function sizeTxt() {
    return "1 MB";
}
function sizeMax() {   
    return 1024;
}

function imgProps() {
    const obj = {
                    avisoTypes: "FORMATOS SOPORTADOS PNG O JPG",
                    avisoSizeSuperado: `PESO MÁXIMO DE ${sizeTxt()} SUPERADO`,
                    avisoHTMLMaxSize: `${sizeTxt()} MÁXIMO POR IMAGEN`,
                    avisoHTMLTypes: "JPG O PNG",
                    avisoHTMLCant: " IMÁGENES MÁXIMO",
                    avisoHTMLMaxSizeLogo: `PESO MÁXIMO DE LA IMAGEN ${sizeTxt()}`
                };    
    return obj;
}

function imgTypes(type) {    
    if ( (type == 'image/jpeg') || 
         (type == 'image/jpg') || 
         (type == 'image/png') ) {
        return false;
    }
    return true;
}

function imgSize(size) {
    if ( (size / 1024) > sizeMax() ) {
        return true;
    }
    return false;
}