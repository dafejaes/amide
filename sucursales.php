<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerBranchOffice.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(1)) {
    header('Location: main.php');
}
$create = $SESSION_DATA->getPermission(3);
$edit = $SESSION_DATA->getPermission(2);
$delete = $SESSION_DATA->getPermission(4);
/**
 * se cargan datos
 */
$SUCURSAL = new ControllerBranchOffice();
$SUCURSAL->sucget();
$arrsucursal = $SUCURSAL->getResponse();
$isvalid = $arrsucursal['output']['valid'];
$arrclientes = $arrsucursal['output']['response'];
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
        $_ACTIVE_SIDEBAR = 'sucursales';
        include 'include/generic_navbar.php';
        ?>
    </div>
    <div class="container">
        <?php
        if ($create) {
            ?>
            <a href="#" id="crearsucursal" class="btn btn-info botoncrear">Crear sucursal</a>
            <?php
        } else {
            ?>
            <a href="#" id="" class="btn btn-info botoncrear">&nbsp;</a>
            <?php
        }
        ?>
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <!--                                <th class="head0" style="width: 140px;">Acciones</th>-->
                    <th class="head0" style="width: 50px;">Acciones</th>
                    <th class="head1"> Nit</th>
                    <th class="head0"> Nombre sucursal</th>
                    <th class="head1">Ciudad</th>
                    <th class="head0">Dirección</th>
                    <th class="head1">Telefono</th>
                    <th class="head0">Cliente</th>
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
                $c = count($arrclientes);
                if ($isvalid) {
                    for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con0">
                                <?php
                                if ($delete) {
                                    ?>
                                    <a href="#" onclick="SUCURSAL.editdata(<?php echo $arrclientes[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($edit) {
                                    ?>
                                    <a href="#" onclick="SUCURSAL.deletedata(<?php echo $arrclientes[$i]['id']; ?>);"><span class="icon-trash"></span></a>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class="con1"><?php echo $arrclientes[$i]['clinit']; ?></td>
                            <td class="con0"><?php echo $arrclientes[$i]['nombre']; ?></td>
                            <td class="con1"><?php echo $arrclientes[$i]['ciudad']; ?></td>
                            <td class="con0"><?php echo $arrclientes[$i]['direccion']; ?></td>
                            <td class="con1"><?php echo $arrclientes[$i]['telefono']; ?></td>
                            <td class="con0"><?php echo $arrclientes[$i]['clinombre']; ?></td>
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
<div id="dialog-form" title="Sucursal" style="display: none;">
    <p class="validateTips"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Cliente</label>
                        <div class="controls">
                            <select name="idcli" id="idcli" class="text ui-widget-content ui-corner-all">
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nombre</label>
                        <div class="controls"><input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Ciudad</label>
                        <div class="controls"><input type="text" name="ciudad" id="ciudad" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Dirección</label>
                        <div class="controls"><input type="text" name="direccion" id="direccion" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Teléfono</label>
                        <div class="controls"><input type="text" name="telefono" id="telefono" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="../danmet/css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/sucursales.js"></script>
</body>
</html>