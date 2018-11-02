<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerClosedOrder.php';
/**
 * se cargan los permisos
 */
if (!$SESSION_DATA->getPermission(26)) {
    header('Location: main.php');
}
/**
 * se cargan datos
 */
$ORDENES = new ControllerClosedOrder();
$ORDENES->ordencerraget();
$arrclientes = $ORDENES->getResponse();
$isvalid = $arrclientes['output']['valid'];
$arrclientes = $arrclientes['output']['response'];
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
        $_ACTIVE_SIDEBAR = 'ordencerrada';
        include 'include/generic_navbar.php';
        ?>
    </div>
    <div class="container">
        <div>
            <table class="table table-hover dyntable" id="dynamictable">
                <thead>
                <tr>
                    <!--                                <th class="head0" style="width: 140px;">Acciones</th>-->
                    <th class="head0">No. orden</th>
                    <th class="head1">Consecutivo</th>
                    <th class="head0">Responsable</th>
                    <th class="head1">Fecha generacion</th>
                    <th class="head0">Inicia</th>
                    <th class="head1">Termina</th>
                    <th class="head0">Horas</th>
                    <th class="head1">Estado</th>
                    <th class="head0">Revisar</th>
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
                $c = count($arrclientes);
                if ($isvalid) {
                    for ($i = 0; $i < $c; $i++) {
                        ?>
                        <tr class="gradeC">
                            <td class="con0"><?php echo $arrclientes[$i]['id']; ?></td>
                            <td class="con1"><?php echo $arrclientes[$i]['consecutivo']; ?></td>
                            <td class="con0"><?php echo $arrclientes[$i]['responsable']; ?></td>
                            <td class="con1"><?php echo $arrclientes[$i]['fechageneracion']; ?></td>
                            <td class="con0"><?php echo $arrclientes[$i]['inicia']; ?></td>
                            <td class="con1"><?php echo $arrclientes[$i]['termina'] ?></td>
                            <td class="con0"><a href="#" onclick="ORDENABIERTA.getpatrones(<?php echo $arrclientes[$i]['id']; ?>);"><span class="icon-folder-open"></span></a><span>&nbsp;&nbsp;</span></td>
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
<div id="dialog-patron" title="Patrones" style="display: none;">
    <p class="validateTips1"></p>
    <table>
        <tr>
            <td>
                <form id="formcreate4" class="form-horizontal">
                    <div class="container">
                        <div>
                            <table class="table table-hover dyntable" id="dynamictable">
                                <thead>
                                <tr>
                                    <th class="head1">Equipo</th>
                                    <th class="head0">Marca</th>
                                    <th class="head1">Modelo</th>
                                    <th class="head0">Placa</th>
                                    <th class="head1">Serie</th>
                                    <th class="head0">Codigo</th>
                                </tr>
                                </thead>
                                <colgroup>
                                    <col class="con1" />
                                    <col class="con0" />
                                    <col class="con1" />
                                    <col class="con0" />
                                    <col class="con1" />
                                    <col class="con0" />

                                </colgroup>
                                <!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                                <tbody id='listapatrones'>
                                </tbody>
                            </table>
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
<script type="text/javascript" src="js/ordenabierta.js"></script>
<script type="text/javascript" src="js/opcionusr.js"></script>
</body>
</html>