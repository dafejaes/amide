<?php

if (isset($_SESSION['usuario'])) {
    ?>
        <div align="left" class= "nav">
            <img class="img-rounded" src="images/prueba.jpg" width="150px">
            <select name="opcusr" id="opcusr" onchange="OPCION_USUARIO.opciones($(this).val(),<?php echo($_SESSION['usuario']['id']);?>)" class="text ui-widget-content ui-corner-all">
                <option value="nada"><?php
                    echo($_SESSION['usuario']['nombre'] . "(" . $_SESSION['usuario']['cargo'] . ")");
                    ?></option>
                <option value="editarinfo">Editar informacion</option>
                <option value="cerrarsesion">Cerrar sesion</option>
            </select>

            <img class="img-polaroid" src="images/favicon3.png" width="150px" align="right">
        </div>


    <div id="dialog-formheader" title="Editar informacion" style="display: none;">
        <p class="validateTips"></p>
        <table>
            <tr>
                <td>
                    <form id="formcreateheader" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Nombre</label>
                            <div class="controls">
                                <input type="text" name="nombreheader" id="nombreheader" value="<?php echo($_SESSION['usuario']['nombre']);?>" readonly="readonly" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Email</label>
                            <div class="controls">
                                <input type="email" name="emailheader" id="emailheader"  value="<?php echo($_SESSION['usuario']['email']);?>" class="text ui-widget-content ui-corner-all" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Contraseña</label>
                            <div class="controls">
                                <input type="password" name="passheader1" id="passheader1"  class="text ui-widget-content ui-corner-all" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Repita Contraseña</label>
                            <div class="controls">
                                <input type="password" name="passheader2" id="passheader2"  class="text ui-widget-content ui-corner-all" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Identificacion</label>
                            <div class="controls">
                                <input type="text" name="identificacionheader" id="identificacionheader"  value = "<?php echo($_SESSION['usuario']['identificacion']);?>" readonly="readonly" class="text ui-widget-content ui-corner-all" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Telefono</label>
                            <div class="controls">
                                <input type="text" name="telefonoheader" id="telefonoheader"  value="<?php echo($_SESSION['usuario']['telefono']);?>" class="text ui-widget-content ui-corner-all" />
                            </div>
                        </div>
                        <div class="control-group">
                            <form enctype="multipart/form-data" method="POST">
                                <label class="control-label">Firma digital</label>
                                <div class="controls">
                                    <input type="file" id="firma" name="image">
                                </div>
                            </form>
                        <div class="control-group">
                            <form enctype="multipart/form-data" method="POST">
                                <label class="control-label">Foto de perfil</label>
                                <div class="controls">
                                    <input type="file" id="perfil" name="image">
                                </div>
                            </form>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
else {

?>
    <div align="center">
    <img src="images/favicon2.png" alt="AntioquiaMide"/>
     </div>
<?php
}

?>

