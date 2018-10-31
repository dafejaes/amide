<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerCertificate.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(22)){
    header('Location: main.php');
}
/**
 * se cargan datos
 */
$USUARIO = new ControllerCertificate();
$USUARIO->certiget();
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
        $_ACTIVE_SIDEBAR = 'certificado';
        include 'include/generic_navbar.php';
        ?>
    </div>
    <div class="container">
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <th class="head1">Consecutivo</th>
                    <th class="head0">Equipo</th>
                    <th class="head1">Extension</th>
                    <th class="head0">Ubicación</th>
                    <!--<th class="head1">Servicio</th>-->
                    <th class="head1">Fecha de recepción</th>
                    <th class="head0">Observación </th>
                    <th class="head1">Certificado</th>
                    <th class="head0">Entregar</th>
                </tr>
                </thead>
                <colgroup>
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                    <!--<col class="con1"/>-->
                    <col class="con1"/>
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />

                </colgroup>
                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                <tbody>
                <?php
                $c = count($arrusuarios);
                //if ($isvalid) {
                    //for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con1"><?php echo /*$arrusuarios[$i]['consecutivo'];*/ '2' ?></td>
                            <td class="con0"><?php echo /*$arrusuarios[$i]['nombre']; */ 'TENSIOMETRO'?></td>
                            <td class="con1"><?php echo /*$arrusuarios[$i]['extension'];*/ '2112' ?></td>
                            <td class="con0"><?php echo /*$arrusuarios[$i]['ubicacion'] . ' Piso ' . $arrusuarios[$i]['piso'] . ' Torre ' . $arrusuarios[$i]['torre'] */ 'Servicio: Servicio 3. En: Torre 2 piso 1 Oficna 2'; ?></td>
                            <!--<td class="con1"><?php //echo $arrusuarios[$i]['servicio']; ?></td>-->
                            <td class="con1"><?php echo /*$arrusuarios[$i]['fechaingreso']*/ '2018-06-18'; ?></td>
                            <td class="con0"><a href="#" "><span class="icon-book"></span></a><span>&nbsp;&nbsp;</span>
                            <td class="con1"><a href="#" "><span class="icon-print"></span></a><span>&nbsp;&nbsp;</span>
                            <td class="con0"><a href="#" "><span class="icon-chevron-right"></span></a><span>&nbsp;&nbsp;</span>
                        </tr>
                        <?php
                    //}
                //}
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<footer id="footer_wrap">
    <?php include 'include/generic_footer.php'; ?>
</footer>
</div><div id="dialog-form" title="Usuario" style="display: none;">
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
                                <option value="Tecnico lider">Director</option>
                                <option value="Tecnico">Técnico</option>
                                <option value="Tecnologo">Metrólogo</option>
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