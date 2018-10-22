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
            <a href="#" onclick="RECEPCION.getconsecutivo(<?php echo $_SESSION['usuario']['id']?>)" class="btn btn-info botoncrear">Crear</a>
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
                    <th class="head0">Certificado recepcion</th>
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
                            <td class="con0"><?php echo $arrusuarios[$i]['nombreequipo']; ?></td>
                            <td class="con1"><?php echo 'Servicio: ' . $arrusuarios[$i]['nombreser'] . '. En: ' . ' Torre ' . $arrusuarios[$i]['torre'] . ' piso ' . $arrusuarios[$i]['piso'] . ' ' . $arrusuarios[$i]['ubicacion']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['extension']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['estado']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['fecharecepcion']; ?></td>
                            <td class="con0"><a href="#" onclick="RECEPCION.getobservacion(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-book"></span></a><span>&nbsp;&nbsp;</span>
                            <td class="con0"><a href="#" onclick="RECEPCION.getcertificado(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-print"></span></a><span>&nbsp;&nbsp;</span>
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
<div id="dialog-recepcion" title="Ingreso de equipo" style="display: none;">
    <p class="validateTips"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <div class="control-group">
                        <div class="controls">
                            <a href="#" id="agregarequipo" class="btn btn-info ">Agregar equipo</a>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nombre</label>
                        <div class="controls"><input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all"  readonly="readonly"/></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Marca</label>
                        <div class="controls"><input type="text" name="marca" id="marca" class="text ui-widget-content ui-corner-all"  readonly="readonly"/></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Modelo</label>
                        <div class="controls"><input type="text" name="modelo" id="modelo" class="text ui-widget-content ui-corner-all"  readonly="readonly"/></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Placa</label>
                        <div class="controls"><input type="text" name="placa" id="placa" class="text ui-widget-content ui-corner-all"  readonly="readonly"/></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Codigo</label>
                        <div class="controls"><input type="text" name="codigo" id="codigo" class="text ui-widget-content ui-corner-all"  readonly="readonly"/></div>
                    </div>
                    <label class="controls">Observaciones de recepción</label>
                    <div class="controls"><textarea id="obsrecep" rows="10" cols="25" wrap="soft"></textarea></div>

                </form>
                </form>
            </td>
            <td>
                <form id="formcreate2" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Consecutivo</label>
                        <div class="controls"><input type="text" name="consecutivo" id="consecutivo" class="text ui-widget-content ui-corner-all"  readonly="readonly"/></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Estado</label>
                        <div class="controls">
                            <input type="text" name="estado" id="estado"  readonly="readonly" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">¿Presenta golpes?</label>
                        <div class="controls">
                            <select name="golpes" id="golpes" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="Administrador">Si</option>
                                <option value="Recepcionista">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">¿Presenta manchas?</label>
                        <div class="controls">
                            <select name="manchas" id="manchas" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">¿Pasa prueba?</label>
                        <div class="controls">
                            <select name="prueba" id="prueba" class="text ui-widget-content ui-corner-all">
                                <option value="seleccione">Seleccione...</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <label class="controls">Observaciones de entrega</label>
                    <div class="controls"><textarea id="obsentre" rows="10" cols="25" wrap="soft"></textarea></div>
                </form>
            </td>

        </tr>
    </table>
</div>
<div id="dialog-equipo" title="Buscar equipo" style="display: none;">
    <section id="section_wrap2">

    </section>
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

<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="../danmet/css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/equiporecep.js"></script>
<script type="text/javascript" src="js/opcionusr.js"></script>
</body>
</html>