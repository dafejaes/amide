$(document).on('ready', initubicacion);
var q, nombre,  allFields, tips;

/**
 * se activa para inicializar el documento
 */
function initubicacion() {
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

    $("#crearubicacion").button().click(function() {
        q.id = 0;
        $("#dialog-form").dialog("open");
    });

    $("#dialog-form").dialog({
        autoOpen: false,
        height: 500,
        width: 500,
        modal: true,
        buttons: {
            "Guardar": function() {
                UBICACION.savedata()
            },
            "Cancelar": function() {
                UTIL.clearForm('formcreate1');
                UTIL.clearForm('formcreate2');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate1');
            UTIL.clearForm('formcreate2');
            updateTips('');
        }
    });

    UBICACION.getcustomer();
}



var UBICACION = {
    deletedata: function(id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.op = '';
            q.id = id;
            UTIL.callAjaxRqst(q, this.deletedatahandler);
        }
    },
    deletedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'usuario.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    getsuc: function(idcli){
        q.id=0;
        q.iddep=0;
        q.idsuc=0;
        q.op = 'suc2get';
        q.idcli=idcli;
        UTIL.callAjaxRqst(q, this.getsucHandler);
    },
    getsucHandler : function(data) {
        UTIL.cursorNormal()
        if (data.output.valid) {
            var res = data.output.response;
            var option = '<option value="seleccione">Seleccione...</option>';
            for (var i in res){
                option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
            }
            $("#idsu").empty();
            $("#idsu").append(option);
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    getasis: function(idsuc){
        q.id=0;
        q.iddep=0;
        q.idsuc=idsuc;
        q.op = 'asisget';
        q.idcli=0;
        UTIL.callAjaxRqst(q, this.getasisHandler);
    },
    getasisHandler : function(data) {
        UTIL.cursorNormal()
        if (data.output.valid) {
            var res = data.output.response;
            var option = '<option value="seleccione">Seleccione...</option>';
            for (var i in res){
                option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
            }
            $("#idsare").empty();
            $("#idsare").append(option);
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editubidata: function(id) {
        q.op = 'ubiget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editubidatahandler);
    },
    editubidatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#idsu').val(res.idsuc);

            $("#dialog-form").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
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
    },
    savedata: function() {
        q.id=0;
        q.op='ubisave';
        q.idsuc=parseInt($('#idsu').val());
        q.idare=parseInt($('#idsare').val());
        q.torre=$('#torre').val();
        q.piso=$('#piso').val();
        q.ubicacion=$('#ubicacion').val();
        q.extension=$('#extension').val()
        debugger
        UTIL.callAjaxRqst(q, this.savedatahandler);
    },
    savedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            window.location = 'ubicacion.php';
        } else {
            updateTips('Error: ' + data.output.response.content);
        }
    }
}
