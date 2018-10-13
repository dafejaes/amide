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
            }if
            ?>

        </ul>
        <ul class="nav pull-right">
            <li><a href="logout.php">Salir</a></li>
            <li class="divider-vertical"></li>
            <!--            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mi cuenta <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Editar cuenta</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Cerrar Sesión</a></li>
                            </ul>
                        </li>-->
        </ul>
    </div>
    <!--    <ul class="breadcrumb">
            <li><a href="clientes.php">Franquicias</a> <span class="divider">/</span></li>
            <li class="active">Ver</li>
        </ul>-->
</div>