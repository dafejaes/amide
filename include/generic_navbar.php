<?php

?>
<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav">
            <?php
            if($SESSION_DATA->getPermission(1)){
                ?>
                <li <?php if ($_ACTIVE_SIDEBAR == "clientes") echo 'class="active"'; ?>><a href="clientes.php">Clientes</a></li>
                <li class="divider-vertical"></li>
                <li <?php if ($_ACTIVE_SIDEBAR == "sucursales") echo 'class="active"'; ?>><a href="sucursales.php">Sucursales</a></li>
                <li class="divider-vertical"></li>
                <?php
            }
            if($SESSION_DATA->getPermission(5)){
                ?>
                <li <?php if ($_ACTIVE_SIDEBAR == "servicios") echo 'class="active"'; ?>><a href="servicio.php">Servicios</a></li>
                <li class="divider-vertical"></li>
                <li <?php if ($_ACTIVE_SIDEBAR == "ubicaciones") echo 'class="active"'; ?>><a href="ubicacion.php">Ubicacion</a></li>
                <li class="divider-vertical"></li>
                <?php
            }
            if($SESSION_DATA->getPermission(13)){
                ?>
                <li <?php if ($_ACTIVE_SIDEBAR == "usuarios") echo 'class="active"'; ?>><a href="usuario.php">Usuarios</a></li>
                <li class="divider-vertical"></li>
                <?php
            }
            if($SESSION_DATA->getPermission(9)) {
                ?>
                <li <?php if ($_ACTIVE_SIDEBAR == "tipoequipos") echo 'class="active"'; ?>><a href="TipoEquipo.php">Tipo Equipos</a></li>
                <li class="divider-vertical"></li>
                <li <?php if ($_ACTIVE_SIDEBAR == "equipos") echo 'class="active"'; ?>><a href="equipo.php">Equipos</a></li>
                <li class="divider-vertical"></li>
                <?php
            }
            if($SESSION_DATA->getPermission(18)) {
                ?>
                <li <?php if ($_ACTIVE_SIDEBAR == "equiporecep") echo 'class="active"'; ?>><a href="EquipoRecep.php">Equipos</a></li>
                <li class="divider-vertical"></li>
                <?php
            }
            if($SESSION_DATA->getPermission(22)) {
            ?>
            <li <?php if ($_ACTIVE_SIDEBAR == "certificado") echo 'class="active"'; ?>><a href="certificado.php">Certificados</a></li>
            <li class="divider-vertical"></li>
            <?php
            }
            if($SESSION_DATA->getPermission(23)) {
            ?>
            <li <?php if ($_ACTIVE_SIDEBAR == "historial") echo 'class="active"'; ?>><a href="Historial.php">Historial</a></li>
            <li class="divider-vertical"></li>
            <?php
            }
            if($SESSION_DATA->getPermission(24)) {
            ?>
            <li <?php if ($_ACTIVE_SIDEBAR == "equipodirect") echo 'class="active"'; ?>><a href="equipodirector.php">Equipos</a></li>
            <li class="divider-vertical"></li>
            <?php
            }
            if($SESSION_DATA->getPermission(25)) {
                ?>
                <li <?php if ($_ACTIVE_SIDEBAR == "ordenabierta") echo 'class="active"'; ?>><a href="ordenabierta.php">Órdenes abiertas</a></li>
                <li class="divider-vertical"></li>
                <?php
            }
            if($SESSION_DATA->getPermission(26)) {
                ?>
                <li <?php if ($_ACTIVE_SIDEBAR == "ordencerrada") echo 'class="active"'; ?>><a href="ordencerrada.php">Órdenes cerradas</a></li>
                <li class="divider-vertical"></li>
                <?php
            }
            ?>

        </ul>
    </div>
    <!--    <ul class="breadcrumb">
            <li><a href="clientes.php">Franquicias</a> <span class="divider">/</span></li>
            <li class="active">Ver</li>
        </ul>-->
</div>