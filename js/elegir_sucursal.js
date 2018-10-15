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
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    $("#crearasistencial").button().click(function() {
        q.id = 0;
        $("#dialog-form1").dialog("open");
    });

    $("#nuevoasistencial").button().click(function() {
        q.id=0;
        ELEGIR_SUCURSAL.saveasis();
    });

    $("#dialog-form1").dialog({
        autoOpen: false,
        height: 400,
        width: 300,
        modal: true,
        buttons: {
            "Cerrar": function() {
                UTIL.clearForm('formcreate1');
                updateTips('');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate1');
            updateTips('');
        }
    });

    $("#elegirsucursal").button().click(function() {
        q.id = 0;
        var bValid = true;
        if ("seleccione" == $("#idsuc").val() || $("#idsuc").val() == null){
            bValid = false;
            alert('Seleccione la sucursal primero');
        }
        if (bValid) {
            $("#dialog-form2").dialog("open");
            ELEGIR_SUCURSAL.getasistencial();
        }
    });


    $("#dialog-form2").dialog({
        autoOpen: false,
        height: 600,
        width: 800,
        modal: true,
        buttons: {
            "Cerrar": function() {
                UTIL.clearForm('formcreate1');
                updateTips('');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate1');
            updateTips('');
        }
    });
    ELEGIR_SUCURSAL.getcustomer();
}



var ELEGIR_SUCURSAL = {
    saveasis:function(){
        nombre = $("#asistencial").val();
        if(nombre!=''){
            q.nombre = nombre;
            q.op = 'asissave';
            q.idsuc = $('#idsuc').val();
            UTIL.callAjaxRqst(q, this.saveasisHandler)
        }else{
            alert('Campo vacío');
        }

    },
    saveasisHandler:function(){
        UTIL.cursorNormal();
        if (data.output.valid) {
            ELEGIR_SUCURSAL.getasistencial();
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
    getasistencial:function(){
        q.id = 0;
        q.idsuc = $('#idsuc').val();
        q.op = 'asisget';
        UTIL.callAjaxRqst(q, this.getasistencialHandler);
    },
    getasistencialHandler:function(data){
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response;
            var option =  '';
                for (var i in res){
                    option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
                }

            $("#selectasistencial").empty();
            $("#selectasistencial").append(option);
        } else {
            if(data.output.response.content == ' Sin resultados.') {
                var option = '<option value="vacio">No hay informacion</option>';
                $("#selectasistencial").empty();
                $("#selectasistencial").append(option);
            }else{
                alert('Error: ' + data.output.response.content);
            }

        }
    },
    getsuc: function(idcli){
        q.op = 'suc2get';
        q.idcli=idcli;
        UTIL.callAjaxRqst(q, this.getsucHandler);
    },
    getsucHandler : function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response;
            var option = '<option value="seleccione">Seleccione...</option>';
            for (var i in res){
                option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
            }
            $("#idsuc").empty();
            $("#idsuc").append(option);
        } else {
            alert('Error: ' + data.output.response.content);
        }
    }
}