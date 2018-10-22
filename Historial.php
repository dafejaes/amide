<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerRecord.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(22)){
    header('Location: main.php');
}
/**
 * se cargan datos
 */
$USUARIO = new ControllerRecord();
$USUARIO->histoget();
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
        $_ACTIVE_SIDEBAR = 'historial';
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
                    <th class="head1">Servicio</th>
                    <th class="head0">Fecha de recepción</th>
                    <th class="head1">Certificado</th>
                </tr>
                </thead>
                <colgroup>
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1"/>
                    <col class="con0"/>
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
                            <td class="con1"><?php echo $arrusuarios[$i]['consecutivo']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['nombre']; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['extension']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['ubicacion'] . ' Piso ' . $arrusuarios[$i]['piso'] . ' Torre ' . $arrusuarios[$i]['torre'] ; ?></td>
                            <td class="con1"><?php echo $arrusuarios[$i]['servicio']; ?></td>
                            <td class="con0"><?php echo $arrusuarios[$i]['fechaingreso']; ?></td>
                            <td class="con1"><a href="#" onclick="HISTORIAL.getcertificado(<?php echo $arrusuarios[$i]['id']; ?>);"><span class="icon-print"></span></a><span>&nbsp;&nbsp;</span>
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
<?php include 'include/generic_script.php'; ?>
<link rel="stylesheet" media="screen" href="../danmet/css/dynamictable.css" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
<script type="text/javascript" src="js/lib/data-sha1.js"></script>
<script type="text/javascript" src="js/usuario.js"></script>
<script type="text/javascript" src="js/opcionusr.js"></script>
</body>
</html>