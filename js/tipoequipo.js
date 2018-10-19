$(document).on('ready', inittipoequipo);
var q, nombre,  allFields, tips;

/**
 * se activa para inicializar el documento
 */
function inittipoequipo() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    tips = $(".validateTips");
    nombre = $("#nombre");
    allFields = $([]).add(nombre);

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    $("#creartipoequipo").button().click(function() {
        q.id = 0;
        $("#dialog-form1").dialog("open");
    });
    $("#crearpartec").button().click(function() {
        q.idpartec = 0;
        $("#dialog-form3").dialog("open");
    });

    $("#crearmargcali").button().click(function() {
        q.idmagcali = 0;
        $("#dialog-form5").dialog("open");
    });
    $("#dialog-form1").dialog({
        autoOpen: false,
        height: 520,
        width: 500,
        modal: true,
        buttons: {
            "Guardar": function () {
                var valido = true;
                allFields.removeClass("ui-state-error");
                valido = valido && checkLength(nombre, "nombre", 3, 50);
                if(valido){
                    TIPO_EQUIPO.savedata();
                }
            },
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
    $("#dialog-form2").dialog({
        autoOpen: false,
        height: 500,
        width: 1000,
        modal: true,
        buttons: {
            "Cerrar": function() {
                UTIL.clearForm('formcreate2');
                updateTips('');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate2');
            updateTips('');
        }
    });
    $("#dialog-form3").dialog({
        autoOpen: false,
        height: 300,
        width: 500,
        modal: true,
        buttons: {
            "Guardar":function () {
                TIPO_EQUIPO.savepartec();
                UTIL.clearForm('fomrcreate3');
            },
            "Cerrar": function() {
                UTIL.clearForm('formcreate3');
                updateTips('');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate3');
            updateTips('');
        }
    });
    $("#dialog-form4").dialog({
        autoOpen: false,
        height: 500,
        width: 1000,
        modal: true,
        buttons: {
            "Cerrar": function() {
                UTIL.clearForm('formcreate4');
                updateTips('');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate4');
            updateTips('');
        }
    });
    $("#dialog-form5").dialog({
        autoOpen: false,
        height: 300,
        width: 500,
        modal: true,
        buttons: {
            "Guardar":function () {
                TIPO_EQUIPO.savemagcali();
                UTIL.clearForm('fomrcreate5');
            },
            "Cerrar": function() {
                UTIL.clearForm('formcreate5');
                updateTips('');
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate5');
            updateTips('');
        }
    });
}



var TIPO_EQUIPO = {
    savepartec: function () {
        q.op = 'partecsave';
        q.nombrepartec = $('#namepartec').val();
        q.valor = $('#valor').val();
        q.unidad = $('#unidad').val();
        UTIL.callAjaxRqst(q, this.savepartecHandler);
    },
    savepartecHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            UTIL.clearForm('formcreate3');
            updateTips('');
            $('#dialog-form3').dialog("close");
            UTIL.clearForm('formcreate2');
            updateTips('');
            $('#dialog-form2').dialog("close");
            this.verpartec(q.id);
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    savemagcali: function () {
        q.op = 'magcalisave';
        q.nombremagcali = $('#namemagcali').val();
        q.inferior = $('#inferior').val();
        q.superior = $('#superior').val();
        q.emax = $('#emax').val();
        q.unidad = $('#unidadmagcali').val();
        UTIL.callAjaxRqst(q, this.savemagcaliHandler);
    },
    savemagcaliHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            UTIL.clearForm('formcreate3');
            updateTips('');
            $('#dialog-form3').dialog("close");
            UTIL.clearForm('formcreate2');
            updateTips('');
            $('#dialog-form2').dialog("close");
            this.verpartec(q.id);
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    savedata: function () {
        q.op = 'tipoeqsave'
        q.clase = $('#clase').val();
        q.nombre = $('#nombre').val();
        q.alias = $('#alias').val();
        q.marca = $('#marca').val();
        q.modelo = $('#modelo').val();
        q.clasificacion = $('#clasificacion').val();
        q.tipo = $('#tipo').val()
        q.id2 = $('#id2').val();
        UTIL.callAjaxRqst(q, this.savedataHandler);
    },
    savedataHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'TipoEquipo.php'
        } else {
            alert('Error: ' + data.output.response.content);
        }

    },
    editdata: function (id) {
        q.id = id;
        q.op = 'tipoeqget';
        UTIL.callAjaxRqst(q, this.editdataHandler);
    },
    editdataHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#nombre').val(res.nombre);
            $('#alias').val(res.alias);
            $('#marca').val(res.marca);
            $('#modelo').val(res.modelo);
            $('#id2').val(res.id2);
            $("#dialog-form1").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    deletedata: function (id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.id = id;
            q.op = 'tipoeqdelete'
            UTIL.callAjaxRqst(q, this.deletedataHandler);
        }
    },
    deletedataHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'TipoEquipo.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    verpartec: function (id) {
        q.id = id;
        q.op = 'partecget';
        UTIL.callAjaxRqst(q, this.verpartecHandler);
    },
    verpartecHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response;
            var option = '';
            for (var i in res) {
                option += '<tr class="gradeC">';
                option += '<td class="con0">';
                option += '<a href="#" onclick="TIPO_EQUIPO.editdatapartec(' + res[i].idpartec + ');"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>';
                option += '<a href="#" onclick="TIPO_EQUIPO.deletedatapartec(' + res[i].idpartec + ');"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>';
                option += '</td>';
                option += '<td class="con1">' + res[i].namepartec + '</td><td class="con0">' + res[i].valor + '</td><td class="con1">' + res[i].unidad + '</td>';
                option += '</tr>';
            }
            $("#listapartec").empty();
            $("#listapartec").append(option);
            $("#dialog-form2").dialog("open");
        } else {
            if (data.output.response.content == " Sin resultados.") {
                option = " Sin resultados.";
                $("#listapartec").empty();
                $("#listapartec").append(option);
                $("#dialog-form2").dialog("open");
            } else {
                alert('Error: ' + data.output.response.content);
            }

        }
    },
    vermagcali: function (id) {
        q.id = id;
        q.op = 'magcaliget';
        UTIL.callAjaxRqst(q, this.vermagcaliHandler);
    },
    vermagcaliHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response;
            var option = '';
            for (var i in res) {
                option += '<tr class="gradeC">';
                option += '<td class="con0">';
                option += '<a href="#" onclick="TIPO_EQUIPO.editdatamagcali(' + res[i].idmagcali + ');"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>';
                option += '<a href="#" onclick="TIPO_EQUIPO.deletedatamagcali(' + res[i].idmagcali + ');"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>';
                option += '</td>';
                option += '<td class="con1">' + res[i].namemagcali + '</td><td class="con0">' + res[i].inferior + '</td><td class="con1">' + res[i].superior + '</td><td class="con0">' + res[i].emax + '</td><td class="con1">' + res[i].unidadmagcali + '</td>';
                option += '</tr>';
            }
            $("#listamagcali").empty();
            $("#listamagcali").append(option);
            $("#dialog-form4").dialog("open");
        } else {
            if (data.output.response.content == " Sin resultados.") {
                option = " Sin resultados.";
                $("#listamagcali").empty();
                $("#listamagcali").append(option);
                $("#dialog-form4").dialog("open");
            } else {
                alert('Error: ' + data.output.response.content);
            }

        }
    },
    editdatapartec: function (idpartec) {
        q.idpartec = idpartec;
        q.op = 'partecget';

        UTIL.callAjaxRqst(q, this.editdatapartecHandler);
    },
    editdatapartecHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#namepartec').val(res.namepartec);
            $('#valor').val(res.valor);
            $('#unidad').val(res.unidad);
            $("#dialog-form3").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    deletedatapartec: function (idpartec) {
        q.idpartec = idpartec;
        q.op = 'partecdelete';
        UTIL.callAjaxRqst(q, this.deletedatapartecHandler);
    },
    deletedatapartecHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'TipoEquipo.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editdatamagcali: function (idmagcali) {

        UTIL.callAjaxRqst(q, this.editdatamagcaliHandler);
    },
    editdatamagcaliHandler: function (data) {

    },
    deletedatamagcali: function (idpartec) {

        UTIL.callAjaxRqst(q, this.deletedatamagcaliHandler);
    },
    deletedatamagcaliHandler: function (data) {

    }
}
