$(document).on('ready', initsucursal);
var q, nombre, estado, allFields, tips;

/**
 * se activa para inicializar el documento
 */
function initsucursal() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    nombre = $("#nombre");
    estado = $("#estado");
    allFields = $([]).add(nombre).add(estado);
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    //UTIL.applyDatepicker('fechainicio');
    //UTIL.applyDatepicker('fechafin');

    $("#crearcliente").button().click(function() {
        q.id = 0;
        $("#dialog-form").dialog("open");
    });

    $("#dialog-form").dialog({
        autoOpen: false, height: 450, width: 500, modal: true,
        buttons: {
            "Guardar": function() {
                var bValid = true;
                allFields.removeClass("ui-state-error");
                bValid = bValid && checkLength(nombre, "nombre", 3, 80);

                if (bValid) {
                    CLIENTE.savedata();
                }
            },
            "Cancelar": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate');
            updateTips('');
        }
    });
}

var CLIENTE = {
    deletedata: function(id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.op = 'clidelete';
            q.id = id;
            UTIL.callAjaxRqst(q, this.deletedatahandler);
        }
    },
    deletedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'clientes.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editdata: function(id) {
        q.op = 'cliget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editdatahandler);
    },
    editdatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#nombre').val(res.nombre);
            $('#estado').val(res.estado);
            $('#tipo').val(res.tipo);
            $('#url').val(res.url);
            $('#nit').val(res.nit);
            $("#dialog-form").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    savedata: function() {
        q.op = 'clisave';
        q.nombre = $('#nombre').val();
        q.estado = $('#estado').val();
        q.tipo = $('#tipo').val();
        q.url = $('#url').val();
        q.nit = $('#nit').val();
        UTIL.callAjaxRqst(q, this.savedatahandler);
    },
    savedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            window.location = 'clientes.php';
        } else {
            updateTips('Error: ' + data.output.response.content);
        }
    }
}
