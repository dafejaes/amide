<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerEquipRecep.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(18)){
    header('Location: main.php');
}
$create = $SESSION_DATA->getPermission(19 );

/**
 * se cargan datos
 */
$USUARIO = new ControllerEquipRecep();
$USUARIO->eqrecepget();
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
        $_ACTIVE_SIDEBAR = 'equiporecep';
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
                    <th class="head1">Consecutivo</th>
                    <th class="head0">Nombre</th>
                    <th class="head1">Ubicacion</th>
                    <th class="head0">Extension</th>
                    <th class="head1">Estado</th>
                    <th class="head0">Fecha de recepcion</th>
                    <th class="head1">Observaciones</th>
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
                            <td class="con0"><?php echo $arrusuarios[$i]['nombreequipo']; ?></td>
                            <td class="con1"><?php echo 'Servicio: ' . $arrusuarios[$i]['nombreser'] . 'En: ' . 'Torre ' . $arrusuarios[$i]['torre'] . ' piso ' . $arrusuarios[$i]['piso'] . ' ' . $arrusuarios[$i]['ubicacion']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['extension']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['estado']; ?></td>
                            <td class="con0"><a href="#" onclick="CLIENTE.editdata(<?php echo $arrclientes[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>/td>
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
</div><div id="dialog-form" title="Ingreso de equipo" style="display: none;">
    <p class="validateTips"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Cliente</label>
                        <div class="controls">
                            <select onchange="USUARIO.getsuc($(this).val())"name="idcli" id="idcli" class="text ui-widget-content ui-corner-all">
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
                        <label class="control-label">Nombre completo</label>
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
                        <label class="control-label">Identificacion</label>
                        <div class="controls"><input type="text" name="identificacion" id="identificacion" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Telefono</label>
                        <div class="controls"><input type="text" name="telefono" id="telefono" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Cargo</label>
                        <div class="controls">
                            <select name="cargo" id="cargo" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Recepcionista">Recepcionista</option>
                                <option value="Tecnico lider">Técnico líder</option>
                                <option value="Tecnico">Técnico</option>
                                <option value="Tecnologo">Tecnólogo</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Habilitado</label>
                        <div class="controls">
                            <select name="estado" id="estado" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="Activo">Si</option>
                                <option value="Inactivo">No</option>
                            </select>
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
<script type="text/javascript" src="js/tipoequipo.js"></script>
<script type="text/javascript" src="js/opcionusr.js"></script>
</body>
</html>