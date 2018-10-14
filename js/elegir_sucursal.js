$(document).on('ready', initservicio);
var q, nombre,  allFields, tips;

/**
 * se activa para inicializar el documento
 */
function initservicio() {
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

    $("#crearasistencial").button().click(function() {
        q.id = 0;
        $("#dialog-form1").dialog("open");
    });


    $("#dialog-form1").dialog({
        autoOpen: false,
        height: 600,
        width: 800,
        modal: true,
        buttons: {
            "Cerrar": function() {
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
    ELEGIR_SUCURSAL.getcustomer();
}



var ELEGIR_SUCURSAL = {
    deletedata: function(id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.op = 'usrdelete';
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
    editdata: function(id) {
        q.op = 'usrget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editdatahandler);
    },
    editdatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#idcli').val(res.idcli);
            $('#nombre').val(res.nombre);
            $('#apellido').val(res.apellido);
            $('#cargo').val(res.cargo);
            $('#email').val(res.email);
            $('#pass').val(res.pass);
            $('#identificacion').val(res.identificacion);
            $('#celular').val(res.celular);
            $('#telefono').val(res.telefono);
            $('#pais').val(res.pais);
            $('#departamento').val(res.departamento);
            $('#ciudad').val(res.ciudad);
            $('#direccion').val(res.direccion);
            $('#habilitado').val(res.habilitado);
            $("#dialog-form").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editpermission: function(id) {
        q.op = 'usrprfget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editpermissionhandler);
    },
    editpermissionhandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var ava = data.output.available;
            var ass = data.output.assigned;
            var chks = '';
            for (var i in ava){
                chks += '<div class="check"><input type="checkbox" name="chk'+ava[i].id+'" id="chk'+ava[i].id+'" value="'+ava[i].id+'" class="text ui-widget-content ui-corner-all" /><span>&nbsp;&nbsp;</span><label>'+ava[i].nombre+'</label></div>';
            }
            $("#formpermission").empty();
            $("#formpermission").append(chks);
            $("#formpermission :input").each(function() {
                var p = $(this).attr('id');
                for (var j in ass){
                    var idchk = 'chk'+ass[j].id;
                    if (p == idchk){
                        $(this).attr('checked', 'true')
                    }
                }
            });
            $("#dialog-permission").dialog("open");
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
    getsuc:function(idcli){
        q.op = 'suc2get';
        q.idcli=idcli;
        UTIL.callAjaxRqst(q, this.getsucHandler);
    },
    getsucHandler : function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response;
            alert(res.nombre);
            var option = '<option value="seleccione">Seleccione...</option>';
            for (var i in res){
                option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
            }
            $("#idsuc").empty();
            $("#idsuc").append(option);
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    savepermission: function() {
        var chk = '';
        var inputs = document.getElementById('formpermission').getElementsByTagName("input"); // get element by tag name
        for (var i in inputs) {
            if (inputs[i].type == "checkbox") {
                if($("#"+inputs[i].id).is(':checked')) {
                    chk += $("#"+inputs[i].id).val()+'-';
                }
            }
        }
        q.op = 'usrprfsave';
        q.chk = chk;
        UTIL.callAjaxRqst(q, this.savepermissionhandler);
    },
    savepermissionhandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            $("#dialog-permission").dialog("close");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    savedata: function() {
        q.op = 'usrsave';
        q.idcli = $('#idcli').val();
        q.nombre = $('#nombre').val();
        q.apellido = $('#apellido').val();
        q.cargo = $('#cargo').val();
        q.email = $('#email').val();
        q.pass = '';
        if ($('#pass').val().length > 1){
            q.pass = hex_sha1($('#pass').val());
        }
        q.identificacion = $('#identificacion').val();
        q.celular = $('#celular').val();
        q.telefono = $('#telefono').val();
        q.pais = $('#pais').val();
        q.departamento = $('#departamento').val();
        q.ciudad = $('#ciudad').val();
        q.direccion = $('#direccion').val();
        q.habilitado = $('#habilitado').val();
        UTIL.callAjaxRqst(q, this.savedatahandler);
    },
    savedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            window.location = 'usuario.php';
        } else {
            updateTips('Error: ' + data.output.response.content);
        }
    }
}