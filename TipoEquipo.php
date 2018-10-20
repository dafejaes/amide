<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerTypeEquipment.php';

/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(9)){
    header('Location: main.php');
}
$create = $SESSION_DATA->getPermission(11);
$edit = $SESSION_DATA->getPermission(10);
$delete = $SESSION_DATA->getPermission(12);

/**
 * se cargan datos
 */

$SERVICIO = new ControllerTypeEquipment();
$SERVICIO->tequiget();
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
        $_ACTIVE_SIDEBAR = 'tipoequipos';
        include 'include/generic_navbar.php';
        ?>
    </div>
    <div class="container">
        <?php
        if ($create) {
            ?>
            <a href="#" id="creartipoequipo" class="btn btn-info botoncrear">Crear tipo equi</a>
            <?php
        }
        ?>
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <th class="head0" style="width: 70px;">Acciones</th>
                    <th class="head1">ID</th>
                    <th class="head0">Nombre</th>
                    <th class="head1">Clase</th>
                    <th class="head0">Alias</th>
                    <th class="head1">Marca</th>
                    <th class="head0">Clasificacion</th>
                    <th class="head1">Tipo</th>
                    <th class="head0" style="width: 70px;">Parametros Técnicos</th>
                    <th class="head0" style="width: 70px;">Magnitudes calibracion</th>

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
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1" />


                </colgroup>
                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                <tbody>
                <?php
                $c = count($arrusuarios);
                if ($isvalid) {
                    for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con0">
                                <?php
                                if ($delete) {
                                    ?>
                                    <a href="#" onclick="TIPO_EQUIPO.editdata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($edit) {
                                    ?>
                                    <a href="#" onclick="TIPO_EQUIPO.deletedata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class="con1"><?php echo $arrusuarios[$i]['id2']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['nombre']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['clase']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['alias']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['marca']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['clasificacion']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['tipo']; ?></td>
                            <td class="con0">
                                <a href="#" onclick="TIPO_EQUIPO.verpartec(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-folder-open"></span></a><span>&nbsp;&nbsp;</span>
                            </td>
                            <td class="con0">
                                <a href="#" onclick="TIPO_EQUIPO.vermagcali(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-folder-open"></span></a><span>&nbsp;&nbsp;</span>
                            </td>
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
<div id="dialog-form1" title="Tipo de equipo" style="display: none;">
    <p class="validateTips1"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Clase</label>
                        <div class="controls">
                            <select name="clase" id="clase" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="Apoyo">Apoyo</option>
                                <option value="Biomedico">Biomédico</option>
                                <option value="Patron">Patrón</option>
                                <option value="Comunicacion">Comunicacion</option>
                                <option value="Industrial">Industrial</option>
                                <option value="Infraestructura">Infraestructura</option>
                                <option value="Sistemas">Sistemas</option>
                                <option value="Sonido">Sonido</option>
                                <option value="Video">Video</option>
                                <option value="Simulador">Simulador</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nombre</label>
                        <div class="controls"><input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Alias</label>
                        <div class="controls"><input type="text" name="alias" id="alias" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Marca</label>
                        <div class="controls"><input type="text" name="marca" id="marca" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Modelo</label>
                        <div class="controls"><input type="text" name="modelo" id="modelo" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Clasificacion</label>
                        <div class="controls">
                            <select name="clase" id="clasificacion" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="clase I">Clase I</option>
                                <option value="clase IIA">Clase IIA</option>
                                <option value="clase IIB">Clase IIB</option>
                                <option value="clase III">Clase III</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Tipo</label>
                        <div class="controls">
                            <select name="clase" id="tipo" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="Electrico">Electrico</option>
                                <option value="Electronico">Electrónico</option>
                                <option value="Electroneumático">Electroneumático</option>
                                <option value="Electromecánico">Electromecánico</option>
                                <option value="Hidraulico">Hidraulico</option>
                                <option value="Mecanico">Mecánico</option>
                                <option value="Neumatico">Neumático</option>
                                <option value="Optico">Optico</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">ID</label>
                        <div class="controls"><input type="text" name="id2" id="id2" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="dialog-form2" title="Parámetros ténicos" style="display: none;">
    <p class="validateTips1"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate2" class="form-horizontal">
                    <div class="container">
                        <a href="#" id="crearpartec" class="btn btn-info botoncrear">Crear</a>
                        <div>
                            <table class="table table-hover dyntable" id="dynamictable">
                                <thead>
                                <tr>
                                    <th class="head0" style="width: 70px;">Acciones</th>
                                    <th class="head1">Nombre</th>
                                    <th class="head0">Valor</th>
                                    <th class="head1">Unidad</th>

                                </tr>
                                </thead>
                                <colgroup>
                                    <col class="con0" />
                                    <col class="con1" />
                                    <col class="con0" />
                                </colgroup>
                                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                                <tbody id="listapartec">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="dialog-form3" title="Nuevo parametro tecnico" style="display: none;">
    <p class="validateTips1"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate3 " class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Nombre</label>
                        <div class="controls"><input type="text" name="namepartec" id="namepartec" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Valor</label>
                        <div class="controls"><input type="text" name="valor" id="valor" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Unidad</label>
                        <div class="controls"><input type="text" name="unidad" id="unidad" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="dialog-form4" title="Magnitudes de calibracion" style="display: none;">
    <p class="validateTips1"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate4" class="form-horizontal">
                    <div class="container">
                        <a href="#" id="crearmargcali" class="btn btn-info botoncrear">Crear</a>
                        <div>
                            <table class="table table-hover dyntable" id="dynamictable">
                                <thead>
                                <tr>
                                    <th class="head0" style="width: 70px;">Acciones</th>
                                    <th class="head1">Nombre</th>
                                    <th class="head0">Limite inferior</th>
                                    <th class="head1">Limite superior</th>
                                    <th class="head0">Error maximo</th>
                                    <th class="head1">Unidad</th>
                                </tr>
                                </thead>
                                <colgroup>
                                    <col class="con0" />
                                    <col class="con1" />
                                    <col class="con0" />
                                    <col class="con1" />
                                    <col class="con0" />
                                    <col class="con1" />
                                </colgroup>
                                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                                <tbody id='listamagcali'>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="dialog-form5" title="Nueva magnitud de calibracion" style="display: none;">
    <p class="validateTips1"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate5 " class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Nombre</label>
                        <div class="controls"><input type="text" name="namemagcali" id="namemagcali" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Limite inferior</label>
                        <div class="controls"><input type="text" name="inferior" id="inferior" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Limite superior</label>
                        <div class="controls"><input type="text" name="superior" id="superior" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Error maximo</label>
                        <div class="controls"><input type="text" name="emax" id="emax" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Unidad</label>
                        <div class="controls"><input type="text" name="unidadmagcali" id="unidadmagcali" class="text ui-widget-content ui-corner-all" /></div>
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
<script type="text/javascript" src="js/tipoequipo.js"></script>
<script type="text/javascript" src="js/opcionusr.js"></script>
</body>
</html>