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

    $("#dialog-orden").dialog({
        autoOpen: false,
        height: 700,
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
    },
    getcertificado:function (id) {
        q.id=id;
        q.op='recepget';
        UTIL.callAjaxRqst(q,this.getcertificadoHandler)
    },
    getcertificadoHandler:function (data){
        UTIL.cursorNormal();
        if(data.output.valid){
            q.todo=data.output.response[0];
            RECEPCION.getrecep();
        }else{
            alert('Error: ' + data.output.response.content);

        }
    },
    getrecep:function () {
        q.id=q.idrecep2;
        q.op='usrget';
        UTIL.callAjaxRqst(q,this.getrecepHandler);
    },
    getrecepHandler:function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            var res = data.output.response[0];
            var todo = q.todo;
            var golpes = '';
            var manchas = '';
            var prueba = '';
              if(todo.golpes == "1"){
                golpes = 'Si';
            }else{
                golpes = 'No'
            }
            if(todo.manchas == "1"){
                manchas='Si';
            }
            else{
                manchas='No';
            }
            if(todo.prueba == "1"){
                prueba='Si';
            }else{
                prueba='No';
            }
            debugger
            var doc = document.open("text/html","replace");
            var text = '<!DOCTYPE><html><head><style type="text/css">\n' +
                '            body{\n' +
                '                /* font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;*/\n' +
                '                font-family: verdana,sans-serif;\n' +
                '                font-size: 12px;\n' +
                '                margin: 0px;\n' +
                '                padding: 0px;\n' +
                '            }\n' +
                '            hr{\n' +
                '                color:  rgb(90,145,202);\n' +
                '                background-color:  rgb(56,98,202);\n' +
                '                border-color: rgb(120,142,202);\n' +
                '                padding: 0px;\n' +
                '                /*margin: -10px;*/\n' +
                '            }\n' +
                '            li {\n' +
                '                page-break-inside: avoid;\n' +
                '                margin-bottom: 4px;\n' +
                '                margin-top: 4px;\n' +
                '                text-align: justify;\n' +
                '            }\n' +
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
                '            }                    </style></head>' +
                '<body>' +
                '   <div class="pagina">' +
                '       <table class="paginatabla">' +
                '           <tr>\n' +
                '                    <td width="100%">\n' +
                '                        <table width="100%">\n' +
                '                            <tr>\n' +
                '                                <td width="100%" class="center">\n' +
                '                                    <span style="font-size: 20px;">RECEPCIÓN DE EQUIPOS</span><br>\n' +
                '                                    <span style="font-size: 14px;">Consecutivo ' +
                '                                       ' + todo.consecutivo +
                '                                    </span>\n' +
                '                                </td>\n' +
                '                                <td>\n' +
                '                                    <table>\n' +
                '                                        <tr>\n' +
                '                                            <td width="100%"><br></td>\n' +
                '                                            <td><img src="images/favicon3.png" style="max-height: 80px;"></td>\n' +
                '                                        </tr>\n' +
                '                                    </table>\n' +
                '                                </td>\n' +
                '                            </tr>\n' +
                '                        </table>\n' +
                '                    </td>' +
                '                </tr>' +
                '                <tr>\n' +
                '                    <td>\n' +
                '                        <table width="100%">\n' +
                '                            <tr>\n' +
                '                                <td colspan="2" class="right"><b>Fecha y hora recepción:</b>' + todo.fechaingreso + '</td>\n' +
                '                            </tr>\n' +
                '                        </table>\n' +
                '                    </td>\n' +
                '                </tr>' +
                '                <tr>\n' +
                '                    <td class="negrita">DATOS CLIENTE</td>\n' +
                '                </tr>' +
                '                <tr>' +
                '                   <td>' +
                '                       <table width="100%">\n' +
                '                            <tr>\n' +
                '                                <td width="60%">\n' +
                '                                    <table width="100%">\n' +
                '                                        <tr>\n' +
                '                                            <td width="20%">Razón Social:</td>\n' +
                '                                            <td>' + todo.sucnombre + '</td>\n' +
                '                                        </tr>\n' +
                '                                        <tr>\n' +
                '                                            <td>NIT:</td>\n' +
                '                                            <td>'+todo.nit+'</td>\n' +
                '                                        </tr>\n' +
                '                                        <tr>\n' +
                '                                            <td>Dirección:</td>\n' +
                '                                            <td>' +
                '                                                '+ todo.direccion+
                '                                            </td>\n' +
                '                                        </tr>\n' +
                '                                        <tr>\n' +
                '                                            <td>Servicio solicitado:</td>\n' +
                '                                            <td>Calibracion</td>\n' +
                '                                        </tr>\n' +
                '                                    </table>\n' +
                '                                </td>\n' +
                '                            </tr>\n' +
                '                        </table>' +
                '                   </td>' +
                '                </tr>' +
                '                <tr>' +
                '                    <td>' +
                '                           <div style="height: 330px;">' +
                '                               <table class="paginatabla gridtable tablaequipos">' +
                '                                   <tr>\n' +
                '                                    <th width="40px">Item</th>\n' +
                '                                    <th>Equipo</th>\n' +
                '                                    <th>Marca</th>\n' +
                '                                    <th>Modelo</th>\n' +
                '                                    <th>Placa</th>\n' +
                '                                    <th>Serie</th>\n' +
                '                                    <th width="80px">Presenta golpes</th>\n' +
                '                                    <th width="80px">Presenta manchas</th>\n' +
                '                                    <th width="100px">Pasa prueba encendido</th>\n' +
                '                                </tr>' +
                '                                <tr>' +
                '                                   <td class="center">1</td>' +
                '                                   <td>'+ todo.equipo +'</td>' +
                '                                   <td>'+ todo.marca +'</td>' +
                '                                   <td>'+ todo.modelo +'</td>' +
                '                                   <td>'+ todo.placa +'</td>' +
                '                                   <td>'+ todo.serie +'</td>' +
                '                                   <td>'+ golpes +'</td>' +
                '                                   <td>'+ manchas +'</td>' +
                '                                   <td>'+ prueba +'</td>' +
                '                               </tr>' +
                '                             </table>' +
                '                         </div>' +
                '                    </td>' +
                '                </tr>' +
                '                <tr>\n' +
                '                    <td>\n' +
                '                        <div>\n' +
                '                            <table id="field01_con" width="100%">\n' +
                '                                <tr>\n' +
                '                                    <td class="justify"><b>Observaciones de entrega:</b>\n' +
                '                                        <span id="field01_p" class="printable justify">\n' +
                '                                        <div style="width: 100%" class="editable"><textarea style="width: 100%" id="field01_e" rows="3" maxlength="300" readonly="readonly">'+todo.obsentre+'</textarea></div>\n' +
                '                                    </td>\n' +
                '                                </tr>\n' +
                '                            </table>\n' +
                '                            <table id="field02_con" width="100%">\n' +
                '                                <tr>\n' +
                '                                    <td class="justify"><b>Observaciones de recepción:</b>\n' +
                '                                        <span id="field02_p" class="printable justify"></span>\n' +
                '                                        <div style="width: 100%" class="editable"><textarea style="width: 100%" id="field02_e" rows="3" maxlength="300" readonly="readonly">'+todo.obsrecep+'</textarea></div>\n' +
                '                                    </td>\n' +
                '                                </tr>\n' +
                '                            </table>\n' +
                '                        </div>\n' +
                '                    </td>\n' +
                '                </tr>' +
                '                <tr>\n' +
                '                    <td>\n' +
                '                        <table class="paginatabla tablaequipos">\n' +
                '                            <tr>\n' +
                '                                <td width="33%">\n' +
                '                                    <table width="100%" class=" gridtable">\n' +
                '                                        <tr>\n' +
                '                                            <td class="center">RECIBE EQUIPOS</td>\n' +
                '                                        </tr>\n' +
                '                                        <tr>\n' +
                '                                            <td>&nbsp;<br>&nbsp;<br></td>\n' +
                '                                        </tr>\n' +
                '                                        <tr>\n' +
                '                                            <td class="center">Nombre - Firma</td>\n' +
                '                                        </tr>\n' +
                '                                    </table>\n' +
                '                                </td>\n' +
                '                                <td width="34%">\n' +
                '                                    <table width="100%" class=" gridtable">\n' +
                '                                        <tr>\n' +
                '                                            <td class="center">ASIGNADO A</td>\n' +
                '                                        </tr>\n' +
                '                                        <tr>\n' +
                '                                            <td>&nbsp;<br>&nbsp;<br></td>\n' +
                '                                        </tr>\n' +
                '                                        <tr>\n' +
                '                                            <td class="center">Nombre - Firma</td>\n' +
                '                                        </tr>\n' +
                '                                    </table>\n' +
                '                                </td>\n' +
                '                                <td width="33%">\n' +
                '                                    <table width="100%" class=" gridtable">\n' +
                '                                        <tr>\n' +
                '                                            <td class="center">ENTREGA EQUIPOS</td>\n' +
                '                                        </tr>\n' +
                '                                        <tr>\n' +
                '                                            <td>&nbsp;<br>&nbsp;<br></td>\n' +
                '                                        </tr>\n' +
                '                                        <tr>\n' +
                '                                            <td class="center">Nombre - Firma</td>\n' +
                '                                        </tr>\n' +
                '                                    </table>\n' +
                '                                </td>\n' +
                '                            </tr>\n' +
                '                        </table>                        \n' +
                '                    </td>' +
                '               </tr>' +
                '<tr>\n' +
                '                    <td>\n' +
                '                        <div class="pagina center">\n' +
                '                            calle 67 No. 53 - 108 MEDELLIN - ANTIOQUIA&nbsp;&nbsp;&nbsp;&nbsp;PBX: 263 8282&nbsp;&nbsp;&nbsp;&nbsp;TEL: 018000 416384\n' +
                '                            <hr style="color: blue"/>\n' +
                '                            WEB: www.udea.edu.co&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EMAIL: udea@udea.edu.co\n' +
                '                        </div>\n' +
                '\n' +
                '                    </td>\n' +
                '                </tr>' +
                '       </table>' +
                '   </div>' +
                '</body>' +
                '</html>';
            doc.write(text);
        }else{
            alert('Error: ' + data.output.response.content);
        }
    },
    generarorden: function (id) {
        q.id=id;

    },
    generarordenHandler: function (data) {
        UTIL.cursorNormal();
        if(data.output.valid){
            $('#infoequipo').append('<tr>\n' +
                '                <th>Nombre</th>\n' +
                '                <th>Marca</th>\n' +
                '                <th>Modelo</th>\n' +
                '                <th>Placa</th>\n' +
                '                <th>Serie</th>\n' +
                '                <th>Codigo</th>\n' +
                '            </tr>\n' +
                '            <tr>\n' +
                '                <td></td>\n' +
                '                <td></td>\n' +
                '                <td></td>\n' +
                '                <td></td>\n' +
                '                <td></td>\n' +
                '                <td></td>\n' +
                '            </tr>');
            $('#dialog-orden').dialog('open');
        }else{
            alert('Error: ' + data.output.response.content);

        }
    }
}
