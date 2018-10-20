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
            <a href="#" id="crearequipo" class="btn btn-info botoncrear">Crear equipo</a>
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
                    <th class="head0">Modelo</th>
                    <th class="head1">Serie</th>
                    <th class="head0">Placa</th>
                    <th class="head1">Codigo</th>
                    <th class="head0">Ubicacion</th>
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
                                    <a href="#" onclick="EQUIPO.editdata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
                                    <?php
                                }
                                if ($edit) {
                                    ?>
                                    <a href="#" onclick="EQUIPO.deletedata(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-trash"></span></a><span>&nbsp;&nbsp;</span>
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
                            <td class="con1"><?php echo $arrusuarios[$i]['codigo']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['ubicacion']; ?></td>
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
<div id="dialog-form" title="Equipo" style="display: none;">
    <p class="validateTips"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate1" class="form-horizontal">
                    <div class="control-group">
                        <div class="controls">
                            <a href="#" id="agregartipoequipo" class="btn btn-info">Agregar tipo de equipo</a>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nombre equipo</label>
                        <div class="controls">
                            <input type="text" name="nombreequipo" id="nombreequipo"  readonly="readonly" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Marca</label>
                        <div class="controls">
                            <input type="text" name="marca" id="marca"  readonly="readonly" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Modelo</label>
                        <div class="controls">
                            <input type="text" name="modelo" id="modelo"  readonly="readonly" />
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <a href="#" id="agregarservicio" class="btn btn-info ">Agregar servicio</a>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Servicio</label>
                        <div class="controls">
                            <input type="text" name="servicio" id="servicio"  readonly="readonly" />
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <a href="#" id="agregarubicacion" class="btn btn-info">Agregar ubicacion</a>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Ubicacion</label>
                        <div class="controls">
                            <input type="text" name="ubicacion" id="ubicacion"  readonly="readonly" />
                        </div>
                    </div>
                </form>
            </td>
            <td>
                <form id="formcreate2" class="form-horizontal">
                    <div>
                        <h3 class="controls">Información básica</h3>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Serie</label>
                        <div class="controls"><input type="text" name="serie" id="serie" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Registro INVIMA</label>
                        <div class="controls"><input type="text" name="invima" id="invima" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Placa</label>
                        <div class="controls"><input type="text" name="placa" id="placa" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Codigo</label>
                        <div class="controls"><input type="text" name="codigo" id="codigo" class="text ui-widget-content ui-corner-all" /></div>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="dialog-form2" title="Buscar tipo de equipo" style="display: none;">
    <section id="section_wrap2">

    </section>
</div>
<div id="dialog-form3" title="Buscar servicio" style="display: none;">
    <section id="section_wrap3">

    </section>
</div>
<div id="dialog-form4" title="Buscar servicio" style="display: none;">
    <section id="section_wrap4">

    </section>
</div>

<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="../danmet/css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/equipo.js"></script>
<script type="text/javascript" src="js/opcionusr.js"></script>
</body>
</html>