$(document).on('ready', initsucursal);
var q, nombre,  allFields, tips;

/**
 * se activa para inicializar el documento
 */
function initsucursal() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    nombre = $("#nombre");
    allFields = $([]).add(nombre);
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    $("#crearsucursal").button().click(function() {
        q.id = 0;
        $("#dialog-form").dialog("open");
    });

    $("#dialog-form").dialog({
        autoOpen: false,
        height: 400,
        width: 500,
        modal: true,
        buttons: {
            "Guardar": function() {
                var bValid = true;
                allFields.removeClass("ui-state-error");
                bValid = bValid && checkLength(nombre, "nombre", 3, 50);
                if ("seleccione" == $("#idcli").val()){
                    bValid = false;
                    updateTips('Seleccione el cliente al cual pertenece el usuario.');
                }
                if (bValid) {
                    SUCURSAL.savedata();
                    //$(this).dialog("close");
                }
            },
            "Cancelar": function() {
                UTIL.clearForm('formcreate1');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate1');
            updateTips('');
        }
    });

    $("#dialog-permission").dialog({
        autoOpen: false,
        height: 530,
        width: 230,
        modal: true,
        buttons: {
            "Guardar": function() {
                var bValid = true;
                allFields.removeClass("ui-state-error");

                if (bValid) {
                    USUARIO.savepermission();
                    //$(this).dialog("close");
                }
            },
            "Cancelar": function() {
                UTIL.clearForm('formpermission');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formpermission');
            updateTips('');
        }
    });

    SUCURSAL.getcustomer();
}



var SUCURSAL = {
    deletedata: function(id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.op = 'sucdelete';
            q.id = id;
            UTIL.callAjaxRqst(q, this.deletedatahandler);
        }
    },
    deletedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'sucursales.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editdata: function(id) {
        q.op = 'sucget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editdatahandler);
    },
    editdatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#idcli').val(res.clinombre);
            $('#nombre').val(res.nombre);
            $('#ciudad').val(res.ciudad);
            $('#direccion').val(res.direccion);
            $('#telefono').val(res.telefono);
            $("#dialog-form").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    savedata: function() {
        q.op = 'sucsave';
        q.idcli = $('#idcli').val();
        q.nombre = $('#nombre').val();
        q.ciudad = $('#ciudad').val();
        q.direccion = $('#direccion').val();
        q.telefono = $('#telefono').val();
        UTIL.callAjaxRqst(q, this.savedatahandler);
    },
    savedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            window.location = 'sucursales.php';
        } else {
            updateTips('Error: ' + data.output.response.content);
        }
    },
    getcustomer:function(){
        q.op = 'cliget';
        UTIL.callAjaxRqst(q, this.getcustomerHandler);
    },
    getcustomerHandler : function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response;
            var option = '<option value="seleccione">Seleccione...</option>';
            for (var i in res){
                option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
            }
            $("#idcli").empty();
            $("#idcli").append(option);
        } else {
            alert('Error: ' + data.output.response.content);
        }
    }
}
