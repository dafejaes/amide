<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerEquipDirect.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(24)){
    header('Location: main.php');
}
/**
 * se cargan datos
 */
$USUARIO = new ControllerEquipDirect();
$USUARIO->directget();
$arrusuarios = $USUARIO->getResponse();
$isvalid = $arrusuarios['output']['valid'];
$arrusuarios = $arrusuarios['output']['response'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'include/generic_head.php'; ?>
</head>
<body>
<style type="text/css">

    hr{
        color:  rgb(90,145,202);
        background-color:  rgb(56,98,202);
        border-color: rgb(120,142,202);
        padding: 0px;
        /*margin: -10px;*/
    }

    p {
        page-break-inside: avoid;
        text-align: justify;
    }
    table.gridtable {
        color:#333333;
        border-width: 1px;
        border-color: #666666;
        border-collapse: collapse;
    }
    table.gridtable th {
        border-width: 1px;
        /*padding: 8px;*/
        border-style: solid;
        border-color: #666666;
        background-color: #dedede;
    }
    table.gridtable td {
        border-width: 1px;
        /*padding: 8px;*/
        border-style: solid;
        border-color: #666666;
        background-color: #ffffff;
    }

    .tablaequipos{
        font-size: 0.8em;
    }

    .paginatabla{ width: 1000px; }

    .printord label{
        cursor: pointer;
    }
</style>
<header>
    <?php
    include 'include/generic_header.php';
    ?>
</header>
<section id="section_wrap">
    <div class="container">
        <?php
        $_ACTIVE_SIDEBAR = 'equipodirect';
        include 'include/generic_navbar.php';
        ?>
    </div>
    <div class="container">
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <th class="head1">Consecutivo</th>
                    <th class="head0">Nombre</th>
                    <th class="head1">Ubicacion</th>
                    <th class="head0">Extension</th>
                    <th class="head1">Estado</th>
                    <th class="head0">Fecha de recepcion</th>
                    <th class="head1">Observaciones</th>
                    <th class="head0">Generar orden</th>
                </tr>
                </thead>
                <colgroup>
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                    <col class="cono1"/>
                    <col class="cono0"/>
                    <col class="cono1" />
                    <col class="con0" />
                </colgroup>
                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                <tbody>
                <?php
                $c = count($arrusuarios);
                if ($isvalid) {
                    for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con1"><?php echo $arrusuarios[$i]['consecutivo']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['nombre']; ?></td>
                            <td class="con1"><?php echo 'Servicio: ' . $arrusuarios[$i]['servicio'] . '. En: ' . ' Torre ' . $arrusuarios[$i]['torre'] . ' piso ' . $arrusuarios[$i]['piso'] . ' ' . $arrusuarios[$i]['ubicacion']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['extension']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['estado']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['fechaingreso']; ?></td>
                            <td class="con0"><a href="#" onclick="EQUIPODIRECT.getobservacion(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-book"></span></a><span>&nbsp;&nbsp;</span>
                            <td class="con0"><a href="#" onclick="EQUIPODIRECT.generarorden(<?php echo $arrusuarios[$i]['id']; ?>,<?php echo $_SESSION['usuario']['id'];?>);"><span class="icon-chevron-right"></span></a><span>&nbsp;&nbsp;</span>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<footer id="footer_wrap">
    <?php include 'include/generic_footer.php'; ?>
</footer>
</div>
<div id="dialog-orden" title="Generar orden de trabajo" style="display: none;">
    <div style="height: 330px;">
        <h4 class="pagination-centered">Equipo</h4>
        <table id="infoequipo" class="paginatabla gridtable tablaequipos">

        </table>
        <div style="height: 50px;">
            <h4 class="pagination-centered">Informacion de la orden</h4>
            <table class="paginatabla gridtable">
                <tr>
                    <td>
                        <form class="form-horizontal" style="color: orange;">
                            <div style="height: 20px"></div>
                            <div class="control-group">
                                <label class="control-label">Consecutivo</label>
                                <div class="controls"><input type="text" name="consecutivo" id="consecutivo" class="text ui-widget-content ui-corner-all" readonly="readonly" /></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Responsable</label>
                                <div class="controls">
                                    <select name="idres" id="idres" class="text ui-widget-content ui-corner-all">
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Fecha generacion</label>
                                <div class="controls"><input type="date" name="fechainicio" id="fechainicio"  value="" readonly="true" class="text ui-widget-content ui-corner-all" /></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Estado</label>
                                <div class="controls">
                                    <select name="idestado" id="idestado" readonly="true" class="text ui-widget-content ui-corner-all">
                                        <option id="pendiente">Pendiente</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td>
                        <form class="form-horizontal" style="color: orange;">
                            <div style="height: 20px"></div>
                            <div class="control-group">
                                <label class="control-label">Inicia trabajo</label>
                                <div class="controls"><input type="date" name="iniciatrabajo" id="iniciatrabajo"  value="" readonly="true" class="text ui-widget-content ui-corner-all" /></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Finaliza trabajo</label>
                                <div class="controls"><input type="date" name="finalizatrabajo" id="finalizatrabajo"  value="" readonly="true" class="text ui-widget-content ui-corner-all" /></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Horas</label>
                                <div class="controls"><input type="time" name="horas" id="horas"  readonly="true" value="00:00"  class="text ui-widget-content ui-corner-all" /></div>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="height: 50px;">
        <div style="height: 20px;"></div>
        <h4 class="pagination-centered">Patrón</h4>
        <div align="lefth">
            <a href="#" id="agregarpatron" class="btn btn-info">Agregar patron</a>
        </div>
        <div id="infopatron">

        </div>
    </div>

</div>
<div id="dialog-observa" title="Observaciones" style="display: none;">
    <p class="validateTips"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate3" class="form-horizontal">
                    <label class="controls">Observaciones de recepción</label>
                    <div class="controls"><textarea id="obsrecep2" rows="10" cols="25" wrap="soft" readonly="readonly"></textarea></div>

                </form>
                </form>
            </td>
            <td>
                <form id="formcreate5" class="form-horizontal">
                    <label class="controls">Observaciones de entrega</label>
                    <div class="controls"><textarea id="obsentre2" rows="10" cols="25" wrap="soft" readonly="readonly"></textarea></div>
                </form>
            </td>

        </tr>
    </table>
</div>
<div id="dialog-patron" title="Patrones" style="display: none;">
    <p class="validateTips1"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate4" class="form-horizontal">
                    <div class="container">
                        <div>
                            <table class="table table-hover dyntable" id="dynamictable">
                                <thead>
                                <tr>
                                    <th class="head0" style="width: 70px;">Select</th>
                                    <th class="head1">Equipo</th>
                                    <th class="head0">Marca</th>
                                    <th class="head1">Modelo</th>
                                    <th class="head0">Placa</th>
                                    <th class="head1">Serie</th>
                                    <th class="head0">Codigo</th>
                                </tr>
                                </thead>
                                <colgroup>
                                    <col class="con0" />
                                    <col class="con1" />
                                    <col class="con0" />
                                    <col class="con1" />
                                    <col class="con0" />
                                    <col class="con1" />
                                    <col class="con0" />

                                </colgroup>
                                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                                <tbody id='listapatrones'>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="../danmet/css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/equipodirector.js"></script>
<script type="text/javascript" src="js/opcionusr.js"></script>
</body>
</html>