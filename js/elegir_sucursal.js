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

    $("#creardepartamento").button().click(function() {
        q.id=0;
        ELEGIR_SUCURSAL.savedep();
    });

    $("#crearservicio").button().click(function() {
        q.id=0;
        ELEGIR_SUCURSAL.saveser();
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

    $("#eliminarasistencial").button().click(function() {
        idasis=$('#selectasistencial').val();
        if($('#selectasistencial').val() == null){
            alert('Debe seleccionar un area asistencial');
        }else{
            ELEGIR_SUCURSAL.deleteasistencial(idasis);
        }
    });

    $("#eliminardepartamento").button().click(function() {
        iddep =$('#selectdepartamento').val();
        if($('#selectdepartamento').val() == null){
            alert('Debe seleccionar un area asistencial');
        }else{
            ELEGIR_SUCURSAL.deletedepartamento(iddep);
        }
    });

    $("#eliminarservicio").button().click(function() {
        idser =$('#selectservicio').val();
        if($('#selectservicio').val() == null){
            alert('Debe seleccionar un area asistencial');
        }else{
            ELEGIR_SUCURSAL.deleteservicio(idser);
        }
    });

    $("#verdepartamento").button().click(function() {
        idasis=$('#selectasistencial').val();
        if($('#selectasistencial').val() == null){
            alert('Debe seleccionar un area asistencial');
        }else{
            ELEGIR_SUCURSAL.getdep(idasis);
        }
    });

    $("#verservicio").button().click(function() {
        iddep=$('#selectdepartamento').val();
        if($('#selectdepartamento').val() == null){
            alert('Debe seleccionar un departamento');
        }else{
            ELEGIR_SUCURSAL.getser(iddep);
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
                window.location='servicio.php';
            }
        },
        close: function() {
            UTIL.clearForm('formcreate1');
            updateTips('');
            window.location='servicio.php';
        }
    });
    ELEGIR_SUCURSAL.getcustomer();
}



var ELEGIR_SUCURSAL = {
    saveasis:function(){
        q.id=0;
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
    saveasisHandler:function(data){
        UTIL.cursorNormal();
        if (data.output.valid){
            $('#asistencial').val('');
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
        var option = '';
        if (data.output.valid) {
            var res = data.output.response;
                for (var i in res){
                    option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
                }

            $("#selectasistencial").empty();
            $("#selectasistencial").append(option);
        } else {
            if(data.output.response.content == ' Sin resultados.') {
                option = '<option value="vacio">No hay informacion</option>';
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
    },
    deleteasistencial: function (idasis) {
        q.op = 'asisdelete';
        q.id = parseInt(idasis);
        UTIL.callAjaxRqst(q, this.deleteasistencialHandler);
    },
    deleteasistencialHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid){
            $('#asistencial').val('');
            $("#selectasistencial").empty();
            window.location = 'servicio.php';

        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    deletedepartamento: function (iddep) {
        q.op = 'depdelete';
        q.id = parseInt(iddep);
        UTIL.callAjaxRqst(q, this.deletedepartamentoHandler);
    },
    deletedepartamentoHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid){
            $('#asistencial').val('');
            $("#selectasistencial").empty();
            window.location = 'servicio.php';

        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    deleteservicio: function (idser) {
        q.op = 'serdelete';
        q.id = parseInt(idser);
        UTIL.callAjaxRqst(q, this.deleteservicioHandler);
    },
    deleteservicioHandler: function (data) {
        UTIL.cursorNormal();
        if (data.output.valid){
            $('#servicio').val('');
            $("#selectservicio").empty();
            window.location = 'servicio.php';

        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    getdep: function (idasis) {
        q.id=0;
        q.op = 'depget';
        q.idasis = parseInt(idasis);
        UTIL.callAjaxRqst(q, this.getdepHandler);
    },
    getdepHandler: function (data) {
        UTIL.cursorNormal();
        var option = '';
        if (data.output.valid) {
            var res = data.output.response;
            for (var i in res){
                option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
            }

            $("#selectdepartamento").empty();
            $("#selectdepartamento").append(option);
        } else {
            if(data.output.response.content == ' Sin resultados.') {
                option = '<option value="vacio">No hay informacion</option>';
                $("#selectdepartamento").empty();
                $("#selectdepartamento").append(option);
            }else{
                alert('Error: ' + data.output.response.content);
            }

        }
    },
    savedep:function(){
        q.id=0;
        nombre = $("#departamento").val();
        if(nombre!=''){
            q.nombre = nombre;
            q.op = 'depsave';
            q.idasis = parseInt($('#selectasistencial').val());
            UTIL.callAjaxRqst(q, this.savedepHandler);
        }else{
            alert('Campo vacío');
        }

    },
    savedepHandler:function(data){
        UTIL.cursorNormal();
        if (data.output.valid){
            $('#departamento').val('');
            ELEGIR_SUCURSAL.getdep(q.idasis);

        } else {
            alert('Error: ' + data.output.response.content);
        }

    },
    getser: function (iddep) {
        q.id=0;
        q.op = 'serget';
        q.idasis=0;
        q.idcli=0;
        q.iddep = parseInt(iddep)
        UTIL.callAjaxRqst(q, this.getserHandler);
    },
    getserHandler: function (data) {
        UTIL.cursorNormal();
        var option = '';
        debugger
        if (data.output.valid) {
            var res = data.output.response;
            for (var i in res){
                option += '<option value="'+res[i].id+'">'+res[i].nombre+'</option>';
            }

            $("#selectservicio").empty();
            $("#selectservicio").append(option);
        } else {
            if(data.output.response.content == ' Sin resultados.') {
                option = '<option value="vacio">No hay informacion</option>';
                $("#selectservicio").empty();
                $("#selectservicio").append(option);
            }else{
                alert('Error: ' + data.output.response.content);
            }

        }
    },
    saveser:function(){
        q.id=0;
        nombre = $("#servicio").val();
        if(nombre!=''){
            q.nombre = nombre;
            q.op = 'sersave';
            q.iddep = parseInt($('#selectdepartamento').val());
            UTIL.callAjaxRqst(q, this.saveserHandler)
        }else{
            alert('Campo vacío');
        }

    },
    saveserHandler:function(data){
        UTIL.cursorNormal();
        if (data.output.valid){
            $('#servicio').val('');
            ELEGIR_SUCURSAL.getser(q.iddep);

        } else {
            alert('Error: ' + data.output.response.content);
        }

    },
}