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

    $("#dialog-patron").dialog({
        autoOpen: false,
        height: 300,
        width: 1025,
        modal: true,
        buttons: {
            "Cerrar": function () {
                $(this).dialog("close");
                $('#listapatrones').empty();
            }
        },
        close: function () {
            updateTips('');
            $('#listapatrones').empty();
        }
    });

    $("#agregarpatron").button().click(function() {
        EQUIPODIRECT.getpatrones();
    });

}



var ORDENABIERTA = {
    getpatrones:function (id) {
        q.id = id;
        q.op ='patronesordenget';
        UTIL.callAjaxRqst(q,this.getpatronesHandler);
    },
    getpatronesHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response;
            var option='';
            for(var i in res){
                option += '<tr class="gradeC">';
                option += '<td class="con1">'+res[i].equipo+'</td>';
                option += '<td class="con0">'+res[i].marca+'</td>';
                option += '<td class="con1">'+res[i].modelo+'</td>';
                option += '<td class="con0">'+res[i].placa+'</td>';
                option += '<td class="con1">'+res[i].serie+'</td>';
                option += '<td class="con0">'+res[i].codigo+'</td>';
                option += '</tr>';
            }
            $('#listapatrones').empty();
            $('#listapatrones').append(option);
            $('#dialog-patron').dialog('open');
        }else{
            alert('Error: ' + data.output.response.content);
        }
    }
}
