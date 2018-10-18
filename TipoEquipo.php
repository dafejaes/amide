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
$EQUIPO = new ControllerTypeEquipment();
$EQUIPO->tequiget();
$arrusuarios = $EQUIPO->getResponse();
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
            <a href="#" id="crearusuario" class="btn btn-info botoncrear">Crear</a>
            <?php
        }
        ?>
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <th class="head0" style="width: 70px;">Acciones</th>
                    <th class="head1">id</th>
                    <th class="head0">Nombre</th>
                    <th class="head1">Clase</th>
                    <th class="head0">Alias</th>
                    <th class="head1">Marca</th>
                    <th class="head0">Modelo</th>
                    <th class="head1">Clasificacion</th>
                    <th class="head0">Tipo</th>
                </tr>
                </thead>
                <colgroup>
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                    <col class="cono1"/>
                    <col class="cono0"/>
                    <col class="cono1"/>
                    <col class="cono0"/>
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
                                if ($edit) {
                                    ?>
                                    <a href="#" onclick="USUARIO.editdata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($delete) {
                                    ?>
                                    <a href="#" onclick="USUARIO.deletedata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($editpermission) {
                                    ?>
                                    <a href="#" onclick="USUARIO.editpermission(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-ban-circle"></span></a>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class="con1"><?php echo $arrusuarios[$i]['id']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['nombre']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['correo']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['telefono']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['cargo']; ?></td>
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
</div><div id="dialog-form" title="Tipo de equipo" style="display: none;">
    <p class="validateTips"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Clase</label>
                        <div class="controls">
                            <select name="clase" id="clase" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="Biomedico">Biomedico</option>
                                <option value="Patron">Patron</option>
                                <option value="Simulador">Simulador</option>
                                <option value="Comunicacion">Comunicacion</option>
                                <option value="Industrial">Industrial</option>
                                <option value="Infraestructura">Infraestructura</option>
                                <option value="Sistemas">Sistemas</option>
                                <option value="Sonido">Sonido</option>
                                <option value="Video">Video</option>
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
                            <select name="clase" id="clase" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="Biomedico">Clase I</option>
                                <option value="Patron">Clase IIA</option>
                                <option value="Comunicacion">Clase IIB</option>
                                <option value="Industrial">CLASE III</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Tipo</label>
                        <div class="controls">
                            <select name="clase" id="clase" class="text ui-widget-content ui-corner-all">
                                <option
                            </select>
                        </div>
                    </div>
                </form>
            </td>
            <td>
                <form id="formcreate2" class="form-horizontal">
                    <table border="1" cellpadding="0" cellspacing="0" class="tabla">
                    </table>
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