$(document).on('ready', initopciones);
var q, nombre, estado, allFields, tips;

/**
 * se activa para inicializar el documento
 */
function initopciones() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    nombre = $("#nombreheader");
    allFields = $([]).add(nombre);
    tips = $(".validateTips");


    $("#dialog-formheader").dialog({
        autoOpen: false, height: 450, width: 500, modal: true,
        buttons: {
            "Guardar": function() {
                OPCION_USUARIO.savedata();
            },
            "Cancelar": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate1');
            updateTips('');
        }
    });
}
var OPCION_USUARIO = {
    opciones: function (operacion, id){
        if(operacion == "editarinfo"){
            $('#dialog-formheader').dialog('open')
        }else if(operacion == "cerrarsesion"){
            window.location = 'logout.php';
        }
    }
}
