<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerCustomer.php';
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
$CLIENTE = new ControllerCustomer();
$CLIENTE->cliget();
$arrclientes = $CLIENTE->getResponse();
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
		$_ACTIVE_SIDEBAR = 'clientes';
		include 'include/generic_navbar.php';
		?>
            </div>
            <div class="container">
		<?php
		if ($create) {
		    ?>
    		<a href="#" id="crearcliente" class="btn btn-info botoncrear">Crear cliente</a>
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
                                <th class="head0" style="width: 50px;">Acciones
                                <th class="head1"> Nit</th>
                                <th class="head0"> Nombre Cliente</th>
                                <th class="head1">Tipo</th>
                                <th class="head0">Url</th>
                                <th class="head1">Estado</th>

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
	    				    <a href="#" onclick="CLIENTE.editdata(<?php echo $arrclientes[$i]['id']; ?>);"><span class="icon-pencil"></span></a><span>&nbsp;&nbsp;</span>
						<?php
					    }
					    if ($edit) {
						?>
	    				    <a href="#" onclick="CLIENTE.deletedata(<?php echo $arrclientes[$i]['id']; ?>);"><span class="icon-trash"></span></a>
						<?php
					    }
					    ?>
					</td>
					<td class="con1"><?php echo $arrclientes[$i]['nit']; ?></td>
					<td class="con0"><?php echo $arrclientes[$i]['nombre']; ?></td>
					<td class="con1"><?php echo $arrclientes[$i]['tipo']; ?></td>
                        <td class="con0"><?php echo $arrclientes[$i]['url']; ?></td>
                        <td class="con1"><?php if($arrclientes[$i]['estado']){
                            echo('Activo');
                            }
                            else{
                            echo('Inactivo');
                            }; ?></td>
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
        <div id="dialog-form" title="Cliente" style="display: none;">
            <p class="validateTips"></p>
            <form class="form-horizontal" id="formcreate">
                <div class="control-group">
                    <label class="control-label">Nombre</label>
                    <div class="controls"><input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Estado</label>
                    <div class="controls">
			<select name="estado" id="estado" class="text ui-widget-content ui-corner-all" >
			    <option value="seleccione">Seleccione...</option>
			    <option value="Activo">Activo</option>
			    <option value="Inactivo">Inactivo</option>
			</select>
		    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tipo</label>
                    <div class="controls">
                        <select name="tipo" id="tipo" class="text ui-widget-content ui-corner-all">
                            <option value="seleccione">Seleccione...</option>
                            <option value="Interno">Interno</option>
                            <option value="Externo">Externo</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">URL</label>
                    <div class="controls"><input type="text" name="url" id="url" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <!-- <div class="control-group">
                    <label class="control-label">Fecha Inicio</label>
                    <div class="controls"><input type="text" name="fechainicio" id="fechainicio" readonly="true" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Fecha Fin</label>
                    <div class="controls"><input type="text" name="fechafin" id="fechafin" readonly="true" class="text ui-widget-content ui-corner-all" /></div>
                </div>-->
                <div class="control-group">
                    <label class="control-label">NIT</label>
                    <div class="controls"><input type="text" name="nit" id="nit" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <!--<div class="control-group">
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
                </div>-->
            </form>
        </div>
	<?php include 'include/generic_script.php'; ?>
        <link rel="stylesheet" media="screen" href="../danmet/css/dynamictable.css" type="text/css" />
        <script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
        <script type="text/javascript" src="js/clientes.js"></script>
        <script type="text/javascript" src="js/opcionusr.js"></script>
    </body>
</html>