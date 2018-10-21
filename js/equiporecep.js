$(document).on('ready', initrecep);
var q, nombre,  allFields, tips;

/**
 * se activa para inicializar el documento
 */
function initrecep() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;


    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    $("#agregarequipo").button().click(function() {
        q.id=0;
        RECEPCION.getequipos();
    });

    $("#dialog-recepcion").dialog({
        autoOpen: false,
        height: 750,
        width: 900,
        modal: true,
        buttons: {
            "Guardar": function () {
                RECEPCION.savedata();
            },
            "Cancelar": function () {
                UTIL.clearForm('formcreate1');
                UTIL.clearForm('formcreate2');
                $(this).dialog("close");
            }
        },
        close: function () {
            UTIL.clearForm('formcreate1');
            UTIL.clearForm('formcreate2');
            updateTips('');
        }
    });
    $("#dialog-equipo").dialog({
        autoOpen: false,
        height: 750,
        width: 950,
        modal: true,
        buttons: {
            "Cancelar": function () {
                $(this).dialog("close");
            }
        },
        close: function () {
            updateTips('');
        }
    });
    $("#dialog-observa").dialog({
        autoOpen: false,
        height: 400,
        width: 1000,
        modal: true,
        buttons: {
            "Cerrar": function () {
                $(this).dialog("close");
            }
        },
        close: function () {
            updateTips('');
        }
    });


}



var RECEPCION = {
    getobservacion:function (id) {
        q.idrecep2=id;
        q.op='obsget';
        UTIL.callAjaxRqst(q,this.getobservacionHandler);
    },
    getobservacionHandler:function (data) {
        UTIL.cursorNormal();
        debugger
        if(data.output.valid){
            var res= data.output.response[0];
            $('#obsentre2').empty();
            $('#obsrecep2').empty();
            $('#obsentre2').val(res.obsentre);
            $('#obsrecep2').val(res.obsrecep);
            $('#dialog-observa').dialog('open')
        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    getconsecutivo: function (idrecep) {
        q.id=0;
        q.idrecep=idrecep;
        q.op = 'conseget';
        UTIL.callAjaxRqst(q,this.getconsecutivoHandler)
    },
    getconsecutivoHandler:function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response[0];
            var res2= parseInt(res.consecutivo);
            $('#consecutivo').val(res2+1);
            $('#estado').val('Pendiente');
            $('#dialog-recepcion').dialog('open');
        }else{
            if(data.output.content = ' Sin resultados.'){
                $('#consecutivo').val(1);
                $('#dialog-recepcion').dialog('open');
                $('#estado').val('Pendiente');
            }
            else{
                alert('Error: ' + data.output.response.content);
            }

        }
    },
    getequipos:function () {
        q.op='eqget';
        UTIL.callAjaxRqst(q,this.getequiposHandler)
    },
    getequiposHandler:function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response;
            var option = '';
            option += '<div class="container">';
            option += '<div>';
            option += '<table class="table table-hover dyntable" id="dynamictable">';
            option += '<thead>';
            option += '<tr><th class="head0" style="width: 70px;">Select</th><th class="head1">ID</th><th class="head0">Nombre</th><th class="head1">Marca</th><th class="head0">Modelo</th><th class="head1">Serie</th><th class="head0">Placa</th><th class="head1">Codigo</th></tr></thead>';
            option += '<colgroup><col class="con0" /><col class="con1" /><col class="con0" /><col class="con1" /><col class="con0" /><col class="con1" /><col class="con0" /><col class="con1" /><col class="con0" /></colgroup>';
            option += '<tbody>';

            for(var i in res){
                option += '<tr class="gradeC"><td class="con0">';
                option += '<a href="#" onclick="RECEPCION.selecttipo(' + res[i].id +');"><span class="icon-bookmark"></span></a><span>&nbsp;&nbsp;</span>';
                option += '</td>';
                option += '<td class="con1">' + res[i].id + '</td><td class="con0">'+res[i].nombre+'</td><td class="con1">'+res[i].marca+'</td><td class="con0">'+res[i].modelo+'</td><td class="con1">'+res[i].serie+'</td><td class="con0">'+res[i].placa+'</td><td class="con1">'+res[i].codigo+'</td>';
                option += '</tr>';
            }
            option += '</tbody></table></div></div>';
            $("#section_wrap2").empty();
            $("#section_wrap2").append(option);
            $("#dialog-equipo").dialog("open");
        } else {
            if (data.output.response.content == " Sin resultados.") {
                option = " Sin resultados.";
                $("#section_wrap2").empty();
                $("#section_wrap2").append(option);
                $("#dialog-equipo").dialog("open");
            } else {
                alert('Error: ' + data.output.response.content);
            }

        }
    },
    selecttipo:function (id) {
        q.id=id;
        q.op='eqget';
        UTIL.callAjaxRqst(q,this.selecttipoHandler);
    },
    selecttipoHandler:function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response[0];
            $('#nombre').empty();
            $('#marca').empty();
            $('#modelo').empty();
            $('#placa').empty();
            $('#codigo').empty();
            $('#nombre').val(res.nombre);
            $('#marca').val(res.marca);
            $('#modelo').val(res.modelo);
            $('#placa').val(res.placa);
            $('#codigo').val(res.codigo);
            q.ideq=res.id;
            $('#dialog-equipo').dialog('close');
        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    savedata:function () {
        q.op='recepsave';
        q.id=0;
        q.obsrecep=$('#obsrecep').val();
        q.consecutivo=parseInt($('#consecutivo').val());
        q.estado=$('#estado').val();
        q.golpes=$('#golpes').val();
        q.manchas=$('#manchas').val();
        q.prueba=$('#prueba').val();
        q.obsentre=$('#obsentre').val();
        UTIL.callAjaxRqst(q, this.savedataHandler);
    },
    savedataHandler:function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'EquipoRecep.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    }
}
