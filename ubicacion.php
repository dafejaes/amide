<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerLocation.php';
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
$UBICACION = new ControllerLocation();
$UBICACION->locatget();
$arrusuarios = $UBICACION->getResponse();
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
        $_ACTIVE_SIDEBAR = 'ubicaciones';
        include 'include/generic_navbar.php';
        ?>
    </div>
    <div class="container">
        <?php
        if ($create) {
            ?>
            <a href="#" id="crearubicacion" class="btn btn-info botoncrear">Crear ubicación</a>
            <?php
        }
        ?>
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <th class="head0" style="width: 70px;">Acciones</th>
                    <th class="head1">Ubicacion</th>
                    <th class="head0">Piso</th>
                    <th class="head1">Torre</th>
                    <th class="head0">Area asistencial</th>
                    <th class="head1">Sucursal</th>
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
                                    <a href="#" onclick="UBICACION.editubidata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($delete) {
                                    ?>
                                    <a href="#" onclick="UBICACION.deletedata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class="con1"><?php echo $arrusuarios[$i]['ubicacion']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['piso']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['torre']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['areanombre']; ?></td>
                            <td class="cono1"><?php echo $arrusuarios[$i]['sucnombre']; ?></td>
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
<div id="dialog-form" title="Ubicación" style="display: none;">
    <p class="validateTips"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Cliente</label>
                        <div class="controls">
                            <select name="idcli" id="idcli" onchange="UBICACION.getsuc($(this).val())" class="text ui-widget-content ui-corner-all">
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Sucursal</label>
                        <div class="controls">
                            <select name="idsu" id="idsu" onchange="UBICACION.getasis($(this).val())" class="text ui-widget-content ui-corner-all">
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Area asistencial</label>
                        <div class="controls">
                            <select name="idsare" id="idsare" class="text ui-widget-content ui-corner-all">
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Torre</label>
                        <div class="controls"><input type="text" name="torre" id="torre" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Piso</label>
                        <div class="controls"><input type="text" name="piso" id="piso" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Ubicación</label>
                        <div class="controls"><input type="text" name="ubicacion" id="ubicacion" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Extensión telefónica</label>
                        <div class="controls"><input type="text" name="extension" id="extension" class="text ui-widget-content ui-corner-all" /></div>
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
<script type="text/javascript" src="js/ubicacion.js"></script>
</body>
</html>