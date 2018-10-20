$(document).on('ready', initequipo);
var q, nombre,  allFields, tips;

/**
 * se activa para inicializar el documento
 */
function initequipo() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });
    $('#dynamictable2').dataTable({
        "sPaginationType": "full_numbers"
    });

    $("#crearequipo").button().click(function() {
        q.id = 0;
        $("#dialog-form").dialog("open");
    });
    $("#agregartipoequipo").button().click(function() {
        q.id = 0;
        EQUIPO.teqget();
    });
    $("#agregarservicio").button().click(function() {
        q.id = 0;
        EQUIPO.serget();
    });
    $("#agregarubicacion").button().click(function() {
        q.id = 0;
        EQUIPO.ubiget();
    });

    $("#dialog-form").dialog({
        autoOpen: false,
        height: 610,
        width: 950,
        modal: true,
        buttons: {
            "Guardar": function () {

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

    $("#dialog-form2").dialog({
        autoOpen: false,
        height: 700,
        width: 950,
        modal: true,
        buttons: {
            "Cancelar": function() {
                UTIL.clearForm('formcreate2');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate2');
            updateTips('');
            $(this).dialog("close");
        }
    });
    $("#dialog-form3").dialog({
        autoOpen: false,
        height: 700,
        width: 950,
        modal: true,
        buttons: {
            "Cancelar": function() {
                UTIL.clearForm('formcreate2');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate2');
            updateTips('');
            $(this).dialog("close");
        }
    });

}



var EQUIPO = {
    teqget:function () {
        q.id=0;
        q.op='tipoeqget';
        UTIL.callAjaxRqst(q,this.teqgetHandler);
    },
    teqgetHandler(data){
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response;
            var option = '';
            option += '<div class="container">';
            option += '<div>';
            option += '<table class="table table-hover dyntable" id="dynamictable">';
            option += '<thead>';
            option += '<tr><th class="head0" style="width: 70px;">Select</th><th class="head1">ID</th><th class="head0">Nombre</th><th class="head1">Clase</th><th class="head0">Alias</th><th class="head1">Marca</th><th class="head0">Clasificacion</th><th class="head1">Tipo</th></tr></thead>';
            option += '<colgroup><col class="con0" /><col class="con1" /><col class="con0" /><col class="con1" /><col class="con0" /><col class="con1" /><col class="con0" /><col class="con1" /><col class="con0" /><col class="con1" /></colgroup>';
            option += '<tbody>';

            for(var i in res){
                option += '<tr class="gradeC"><td class="con0">';
                option += '<a href="#" onclick="EQUIPO.selecttipo(' + res[i].id + ');"><span class="icon-bookmark"></span></a><span>&nbsp;&nbsp;</span>';
                option += '</td>';
                option += '<td class="con1">' + res[i].id2 + '</td><td class="con0">'+res[i].nombre+'</td><td class="con1">'+res[i].clase+'</td><td class="con0">'+res[i].alias+'</td><td class="con1">'+res[i].marca+'</td><td class="con0">'+res[i].clasificacion+'</td><td class="con1">'+res[i].tipo+'</td>';
                option += '</tr>';
            }
            option += '</tbody></table></div></div>';
            $("#section_wrap2").empty();
            $("#section_wrap2").append(option);
            $("#dialog-form2").dialog("open");
        } else {
            if (data.output.response.content == " Sin resultados.") {
                option = " Sin resultados.";
                $("#section_wrap2").empty();
                $("#section_wrap2").append(option);
                $("#dialog-form2").dialog("open");
            } else {
                alert('Error: ' + data.output.response.content);
            }

        }
    },
    selecttipo:function (id) {
        q.id=id;
        q.op='tipoeqget';
        UTIL.callAjaxRqst(q,this.selectipoHandler)
    },
    selectipoHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response[0];
            $('#nombreequipo').empty();
            $('#marca').empty();
            $('#modelo').empty();
            $('#nombreequipo').val(res.nombre);
            $('#marca').val(res.marca);
            $('#modelo').val(res.modelo);
            q.idtipoeq=res.id;
            $('#dialog-form2').dialog('close');
        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    serget:function () {
        q.id=0;
        q.op='serget2';
        UTIL.callAjaxRqst(q,this.sergetHandler);
    },
    sergetHandler:function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response;
            var option = '';
            option += '<div class="container">';
            option += '<div>';
            option += '<table class="table table-hover dyntable" id="dynamictable">';
            option += '<thead>';
            option += '<tr><th class="head0">Select</th><th class="head1">ID</th><th class="head0">Servicio</th><th class="head1">Departamento</th><th class="head0">Area asistencial</th></tr></thead>';
            option += '<colgroup><col class="con0" /><col class="con1" /><col class="con0" /><col class="con1" /><col class="con0" /><col class="con1" /></colgroup>';
            option += '<tbody>';

            for(var i in res){
                option += '<tr class="gradeC"><td class="con0">';
                option += '<a href="#" onclick="EQUIPO.selectser(' + res[i].id + ');"><span class="icon-bookmark"></span></a><span>&nbsp;&nbsp;</span>';
                option += '</td>';
                option += '<td class="con1">' + res[i].id + '</td><td class="con0">' + res[i].sernombre + '</td><td class="con1">' + res[i].depnombre + '</td><td class="con0">' + res[i].arenombre + '</td>';
                option += '</tr>';
            }
            option += '</tbody></table></div></div>';
            $("#section_wrap3").empty();
            $("#section_wrap3").append(option);
            $("#dialog-form3").dialog("open");
        } else {
            if (data.output.response.content == " Sin resultados.") {
                option = " Sin resultados.";
                $("#section_wrap3").empty();
                $("#section_wrap3").append(option);
                $("#dialog-form3").dialog("open");
            } else {
                alert('Error: ' + data.output.response.content);
            }

        }
    },
    selectser:function (id) {
        q.id=id;
        q.op='serget2';
        UTIL.callAjaxRqst(q,this.selectserHandler)
    },
    selectserHandler:function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response[0];
            $('#servicio').empty();
            $('#servicio').val(res.sernombre);
            q.idser=res.id;
            $('#dialog-form3').dialog('close');
        }else{
            alert('Error: ' + data.output.response.content);
        }
    }

}