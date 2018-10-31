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
    $("#dialog-orden").dialog({
        autoOpen: false,
        height: 700,
        width: 1025,
        modal: true,
        buttons: {
            "Guardar": function () {
                EQUIPODIRECT.saveorden();
            },
            "Cerrar": function () {
                $(this).dialog("close");
                $('#infoequipo').empty();
            }
        },
        close: function () {
            updateTips('');
            $('#infoequipo').empty();
        }
    })
    $("#dialog-patron").dialog({
        autoOpen: false,
        height: 700,
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



var EQUIPODIRECT = {
    getobservacion:function (id) {
        q.idrecep2=id;
        q.op='obsget';
        UTIL.callAjaxRqst(q,this.getobservacionHandler);
    },
    getobservacionHandler:function (data) {
        UTIL.cursorNormal();
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
    generarorden: function (id,iddirector) {
        q.id=id;
        q.patrones = [];
        q.idrecep3 = id;
        q.iddirector=iddirector;
        q.op='recepget';
        UTIL.callAjaxRqst(q,this.generarordenHandler);
    },
    generarordenHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res= data.output.response[0];
            var text = '<!DOCTYPE><html><head><style type="text/css">\n' +
                '            hr{\n' +
                '                color:  rgb(90,145,202);\n' +
                '                background-color:  rgb(56,98,202);\n' +
                '                border-color: rgb(120,142,202);\n' +
                '                padding: 0px;\n' +
                '                /*margin: -10px;*/\n' +
                '            }\n'+
                '            p { \n' +
                '                page-break-inside: avoid;\n' +
                '                text-align: justify;\n' +
                '            } \n' +
                '            table.gridtable {\n' +
                '                color:#333333;\n' +
                '                border-width: 1px;\n' +
                '                border-color: #666666;\n' +
                '                border-collapse: collapse;\n' +
                '            }\n' +
                '            table.gridtable th {\n' +
                '                border-width: 1px;\n' +
                '                /*padding: 8px;*/\n' +
                '                border-style: solid;\n' +
                '                border-color: #666666;\n' +
                '                background-color: #dedede;\n' +
                '            }\n' +
                '            table.gridtable td {\n' +
                '                border-width: 1px;\n' +
                '                /*padding: 8px;*/\n' +
                '                border-style: solid;\n' +
                '                border-color: #666666;\n' +
                '                background-color: #ffffff;\n' +
                '            }\n' +
                '            .hrfirma{\n' +
                '                color:  black;\n' +
                '                background-color:  black;\n' +
                '                border-color: black;\n' +
                '                padding: 0px;\n' +
                '                /*margin: -10px;*/\n' +
                '            }\n' +
                '            .border0{\n' +
                '                border: 0px !important;\n' +
                '            }\n' +
                '            .ingles{\n' +
                '                font-style: italic;\n' +
                '                color: rgb(19,31,128);\n' +
                '                font-size: 0.8em;\n' +
                '            }\n' +
                '            .justify{\n' +
                '                text-align: justify;\n' +
                '            }\n' +
                '            .center{\n' +
                '                text-align: center;\n' +
                '            }\n' +
                '            .right{\n' +
                '                text-align: right;\n' +
                '            }\n' +
                '            .negrita{\n' +
                '                font-weight: bold;\n' +
                '            }\n' +
                '            .tablaequipos{\n' +
                '                font-size: 0.8em;\n' +
                '            }\n' +
                '            .titlehospital{\n' +
                '                color: rgb(24,79,128);\n' +
                '                text-align: justify;\n' +
                '                display: inline-block;\n' +
                '                vertical-align: top;\n' +
                '            }\n' +
                '            .pagina{ width: 1000px; }\n' +
                '            .paginatabla{ width: 1000px; }\n' +
                '            .pieportada{\n' +
                '                color: rgb(53,87,128);\n' +
                '                text-align: center;\n' +
                '            }\n' +
                '\n' +
                '            .printord{\n' +
                '                background-color: #eee;\n' +
                '                -moz-box-shadow: 10px 10px 5px #888;\n' +
                '                -webkit-box-shadow: 10px 10px 5px #888;\n' +
                '                box-shadow: 10px 10px 5px #888;\n' +
                '                border-width: 1px;\n' +
                '                border-radius: 0.4em;\n' +
                '                border-style: solid;\n' +
                '                border-color: black;\n' +
                '                color: blue;\n' +
                '                cursor: pointer;\n' +
                '                font-weight: bold;\n' +
                '                font-size: 2em;\n' +
                '                height: 50px;\n' +
                '                margin: 1em;\n' +
                '                position: fixed;\n' +
                '                right: 10px;\n' +
                '                text-align: center;\n' +
                '                width: 200px;\n' +
                '            }\n' +
                '\n' +
                '            .printord label{\n' +
                '                cursor: pointer;\n' +
                '            }</style></head>' +
                '<body>' +
                '   <div style="height: 50px;">' +
                '       <table class="paginatabla gridtable tablaequipos">' +
                '           <tr>\n' +
                '               <th>Equipo</th>\n' +
                '               <th>Marca</th>\n' +
                '               <th>Modelo</th>\n' +
                '               <th>Placa</th>\n' +
                '               <th>Serie</th>\n' +
                '           </tr>' +
                '           <tr>' +
                '               <td>'+ res.equipo +'</td>' +
                '               <td>'+ res.marca +'</td>' +
                '               <td>'+ res.modelo +'</td>' +
                '               <td>'+ res.placa +'</td>' +
                '               <td>'+ res.serie +'</td>' +
                '           </tr>' +
                '        </table>' +
                '     </div>' +
                '</body>';
            n =  new Date();
            //Año
            y = n.getFullYear();
            //Mes
            m = n.getMonth() + 1;
            //Día
            d = n.getDate();

            //Lo ordenas a gusto.
            $('#infoequipo').empty();
            $('#infoequipo').append(text);
            $('#consecutivo').val(res.consecutivo);
            var fecha = new Date(); //Fecha actual
            var mes = fecha.getMonth()+1; //obteniendo mes
            var dia = fecha.getDate(); //obteniendo dia
            var ano = fecha.getFullYear(); //obteniendo año
            if(dia<10) {
                dia = '0' + dia; //agrega cero si el menor de 10
            }
            if(mes<10) {
                mes = '0' + mes //agrega cero si el menor de 10
            }
            document.getElementById('fechainicio').value=ano+"-"+mes+"-"+dia;
            document.getElementById('iniciatrabajo').value=ano+"-"+mes+"-"+dia;
            q.idrecep=res.id;
            EQUIPODIRECT.getmetrologos();
        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    getmetrologos: function () {
        q.id=0;
        q.op='metroget';
        UTIL.callAjaxRqst(q, this.getmetrologosHandler);
    },
    getmetrologosHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response;
            var option = '';
            for (var i in res){
                option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
            }
            $("#idres").empty();
            $("#idres").append(option);
            q.text = '<table class="paginatabla gridtable tablaequipos">' +
                '           <tr>' +
                '               <th>Eliminar</th>'+
                '               <th>Marca</th>' +
                '               <th>Modelo</th>' +
                '               <th>Placa</th>' +
                '               <th>Serie</th>' +
                '               </tr>'
                '      </table>';
            $('#infopatron').empty();
            $('#infopatron').append(q.text);
            $('#dialog-orden').dialog('open');
        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    getpatrones:function () {
        q.id = 0;
        q.op ='patronesget';
        UTIL.callAjaxRqst(q,this.getpatronesHandler);
    },
    getpatronesHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response;
            var option='';
            for(var i in res){
                option += '<tr class="gradeC">';
                option += '<td class="con0"><a href="#" onclick="EQUIPODIRECT.getpatron('+res[i].id+')"><span class="icon-arrow-left"></span></a><span>&nbsp;&nbsp;</span>';
                option += '<td class="con1">'+res[i].nombre+'</td>';
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
    },
    getpatron: function (id) {
        q.id = id;
        q.op = 'patronesget';
        UTIL.callAjaxRqst(q,this.getpatronHandler);
    },
    getpatronHandler:function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            q.patrones.push(data.output.response[0]);
            q.text='';
            q.text = '<table class="paginatabla gridtable tablaequipos">' +
                '           <tr>' +
                '               <th>Eliminar</th>'+
                '               <th>Equipo</th>' +
                '               <th>Marca</th>' +
                '               <th>Modelo</th>' +
                '               <th>Placa</th>' +
                '               <th>Serie</th>' +
                '           </tr>';
            for(var i in q.patrones){
                q.text += '<tr class="gradeC">';
                q.text += '<td width="40px"><a href="#" onclick="EQUIPODIRECT.deletepatron('+q.patrones.indexOf(q.patrones[i])+')"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>';
                q.text += '<td>'+q.patrones[i].nombre+'</td>';
                q.text += '<td>'+q.patrones[i].marca+'</td>';
                q.text += '<td>'+q.patrones[i].modelo+'</td>';
                q.text += '<td>'+q.patrones[i].placa+'</td>';
                q.text += '<td>'+q.patrones[i].serie+'</td>';
            }
            q.text += '</table>';
            $('#infopatron').empty();
            $('#infopatron').append(q.text);
            $('#dialog-patron').dialog('close');
        } else{
            alert('Error: ' + data.output.response.content);
        }
    },
    deletepatron: function (index) {
        q.patrones.splice(index, 1)
        $('#infopatron').empty();
        q.text='';
        q.text = '<table class="paginatabla gridtable tablaequipos">' +
            '           <tr>' +
            '               <th>Eliminar</th>'+
            '               <th>Equipo</th>' +
            '               <th>Marca</th>' +
            '               <th>Modelo</th>' +
            '               <th>Placa</th>' +
            '               <th>Serie</th>' +
            '           </tr>';
        for(var i in q.patrones){
            q.text += '<tr class="gradeC">';
            q.text += '<td width="40px"><a href="#" onclick="EQUIPODIRECT.deletepatron('+q.patrones[i]+')"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>';
            q.text += '<td>'+q.patrones[i].nombre+'</td>';
            q.text += '<td>'+q.patrones[i].marca+'</td>';
            q.text += '<td>'+q.patrones[i].modelo+'</td>';
            q.text += '<td>'+q.patrones[i].placa+'</td>';
            q.text += '<td>'+q.patrones[i].serie+'</td>';
        }
        q.text += '</table>';
        $('#infopatron').append(q.text);
    },
    saveorden: function () {
        q.id=0;
        q.op='ordensave';
        q.idresponsable = $('#idres').val();
        UTIL.callAjaxRqst(q, this.saveordenHandler);
    },
    saveordenHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            EQUIPODIRECT.editestado();
        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    editestado: function () {
        q.id = q.idrecep3;
        q.op = 'estadoordenedit';
        UTIL.callAjaxRqst(q, this.editestadoHandler);
    },
    editestadoHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            $('#infoequipo').empty();
            $('#listapatrones').empty();
            $('#dialog-orden').dialog('close');
            window.location = 'equipodirector.php';
        }else{
            alert('Error: ' + data.output.response.content);
        }
    }
}
