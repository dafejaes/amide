<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerEquipments.php';
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
$USUARIO = new ControllerEquipments();
$USUARIO->eqget();
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
<header>
    <?php
    include 'include/generic_header.php';
    ?>
</header>
<section id="section_wrap">
    <div class="container">
        <?php
        $_ACTIVE_SIDEBAR = 'equipos';
        include 'include/generic_navbar.php';
        ?>
    </div>
    <div class="container">
        <?php
        if ($create) {
            ?>
            <a href="#" id="crearusuario" class="btn btn-info botoncrear">Crear equipo</a>
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
                    <th class="head1">Marca</th>
                    <th class="head0">Serie</th>
                    <th class="head1">Placa</th>
                    <th class="head0">Codigo</th>
                    <th class="head1">Ubicacion</th>
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
                    <col class="head1">
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
                                    <a href="#" onclick="USUARIO.editdata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($edit) {
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
                            <td class="con1"><?php echo $arrusuarios[$i]['marca']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['modelo']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['serie']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['placa']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['placa']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['codigo']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['ubicacion']; ?></td>
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
<div id="dialog-form" title="Usuario" style="display: none;">
    <p class="validateTips"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Pertenenece a</label>
                        <div class="controls">
                            <select name="idcli" id="idcli" class="text ui-widget-content ui-corner-all">
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nombres</label>
                        <div class="controls"><input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls"><input type="email" name="email" id="email" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Contraseña</label>
                        <div class="controls"><input type="password" name="pass" id="pass" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Repita Contraseña</label>
                        <div class="controls"><input type="password" name="pass1" id="pass1" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Identificación</label>
                        <div class="controls"><input type="text" name="identificacion" id="identificacion" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Cargo</label>
                        <div class="controls"><input type="text" name="cargo" id="cargo" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                </form>
            </td>
            <td>
                <form id="formcreate2" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Celular</label>
                        <div class="controls"><input type="text" name="celular" id="celular" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Telefono</label>
                        <div class="controls"><input type="text" name="telefono" id="telefono" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">País</label>
                        <div class="controls"><input type="text" name="pais" id="pais" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Departamento</label>
                        <div class="controls"><input type="text" name="departamento" id="departamento" class="text ui-widget-content ui-corner-all" /></div>
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
                        <label class="control-label">Habilitado</label>
                        <div class="controls"><select name="habilitado" id="habilitado" class="text ui-widget-content ui-corner-all">
                                <option value="1">Sí</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">&nbsp;</div>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="dialog-permission" title="Permisos">
    <p class="validateTips"></p>
    <form class="form-horizontal" id="formpermission">
        <div class="check"><input type="checkbox" checked="true" name="chk1" id="chk1" class="text ui-widget-content ui-corner-all" /><span>&nbsp;&nbsp;</span><label>Franquicia</label></div>
    </form>
</div>
<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="../danmet/css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/usuario.js"></script>
<script type="text/javascript" src="js/opcionusr.js"></script>
</body>
</html>