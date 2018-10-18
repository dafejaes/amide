<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerService.php';

/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(5)){
    header('Location: main.php');
}
$create = $SESSION_DATA->getPermission(7);
$edit = $SESSION_DATA->getPermission(6);
$delete = $SESSION_DATA->getPermission(8);

/**
 * se cargan datos
 */

$SERVICIO = new ControllerService();
$SERVICIO->serget();
$arrusuarios = $SERVICIO->getResponse();
$isvalid = $arrusuarios['output']['valid'];
$arrusuarios = $arrusuarios['output']['response'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'include/generic_head.php'; ?>
</head>
<body>
<header>
    <?php
    include 'include/generic_header.php';
    ?>
</header>
<section id="section_wrap">
    <div class="container">
        <?php
        $_ACTIVE_SIDEBAR = 'servicios';
        include 'include/generic_navbar.php';
        ?>
    </div>
    <div class="container">
        <?php
        if ($create) {
            ?>
            <a href="#" id="crearasistencial" class="btn btn-info botoncrear">Config servicios</a>
            <?php
        }
        ?>
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <!--<th class="head0" style="width: 70px;">Acciones</th>-->
                    <th class="head1">ID</th>
                    <th class="head0">Servicio</th>
                    <th class="head1">Departamento</th>
                    <th class="head0">Area asistencial</th>
                    <th class="head1">Sucursal</th>
                </tr>
                </thead>
                <colgroup>
                    <!--<col class="con0" />-->
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1"/>
                </colgroup>
                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                <tbody>
                <?php
                $c = count($arrusuarios);
                if ($isvalid) {
                    for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con1"><?php echo $arrusuarios[$i]['id']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['sernombre']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['depnombre']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['arenombre']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['sucnombre']; ?></td>
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
<div id="dialog-form1" title="Servicios" style="display: none;">
    <p class="validateTips1"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <form>
                        <fieldset>
                            <h4>Elegir sucursal</h4>
                        </fieldset>
                    </form>
                    <div class="control-group">
                        <label class="control-label">Cliente</label>
                        <div class="controls">
                            <select name="idcli" id="idcli" onchange="ELEGIR_SUCURSAL.getsuc($(this).val())" class="text ui-widget-content ui-corner-all">
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Sucursal</label>
                        <div class="controls">
                            <select name="idsuc" id="idsuc" class="text ui-widget-content ui-corner-all">
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <a href="#" id="elegirsucursal" class="btn btn-info">Elegir</a>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="dialog-form2" title="Servicios" style="display: none;">
    <p class="validateTips"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <form>
                        <fieldset>
                            <h4>Area asistencial</h4>
                            <br/>
                            <select style="height: 300px" id="selectasistencial" name="selectasistencial" multiple>
                            </select>
                            <div>
                                <input type="text" name="asistencial" id="asistencial" class="text ui-widget-content ui-corner-all" />
                            </div>
                            <div>
                                <a href="#" id="nuevoasistencial" class="btn btn-info">Crear</a>
                                <a href="#" id="eliminarasistencial" class="btn btn-info">Eliminar</a>
                            </div>

                        </fieldset>
                    </form>
                </form>
            </td>
            <td>
                <form id="formcreate2" class="form-horizontal">
                    <form>
                        <fieldset>
                            <a href="#" id="verdepartamento" class="btn btn-info">>></a>
                        </fieldset>
                    </form>
                </form>
            </td>
            <td>
                <form id="formcreate3" class="form-horizontal">
                    <form>
                        <fieldset>
                            <h4>Departamento</h4>
                            <br/>
                            <select style="height: 300px" id="selectdepartamento" multiple>
                                <option value="vaciodepartamento">Seleccione area asistencial</option>
                            </select>
                            <div>
                                <input type="text" name="departamento" id="departamento" class="text ui-widget-content ui-corner-all" />
                            </div>
                            <div>
                                <a href="#" id="creardepartamento" class="btn btn-info">Crear</a>
                                <a href="#" id="eliminardepartamento" class="btn btn-info">Eliminar</a>
                            </div>

                        </fieldset>
                    </form>
                </form>
            </td>
            <td>
                <form id="formcreate4" class="form-horizontal">
                    <form>
                        <fieldset>
                            <a href="#" id="verservicio" style="" class="btn btn-info">>></a>
                        </fieldset>
                    </form>
                </form>
            </td>
            <td>
                <form id="formcreate5" class="form-horizontal">
                    <form>
                        <fieldset>
                            <h4>Servicio</h4>
                            <br/>
                            <select style="height: 300px" id="selectservicio" multiple>
                                <option value="vaciodepartamento">Seleccione departamento</option>
                            </select>
                            <div>
                                <input type="text" name="servicio" id="servicio" class="text ui-widget-content ui-corner-all" />
                            </div>
                            <div>
                                <a href="#" id="crearservicio" class="btn btn-info">Crear</a>
                                <a href="#" id="eliminarservicio" class="btn btn-info">Eliminar</a>
                            </div>

                        </fieldset>
                    </form>
                </form>
            </td>
        </tr>
    </table>
</div>

<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="../danmet/css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/elegir_sucursal.js"></script>
<script type="text/javascript" src="js/opcionusr.js"></script>
</body>
</html>