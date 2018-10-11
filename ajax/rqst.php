<?php

/**
 * en este archivo se atienden todas las peticiones AJAX
 */
$rqst = $_REQUEST;
$op = isset($rqst['op']) ? $rqst['op'] : '';
header("Content-type: application/javascript; charset=utf-8");
header("Cache-Control: max-age=15, must-revalidate");
header('Access-Control-Allow-Origin: *');
if ($op == 'clisave' || $op == 'cliget' || $op == 'clidelete') {
    include '../lib/ControllerCustomer.php';
    $CONTROL = new ControllerCustomer();
    echo $CONTROL->getResponseJSON();
} else if ($op == 'usrsave' || $op == 'usrget' || $op == 'usrdelete' || $op == 'usrlogin' || $op == 'usrprfget' || $op == 'usrprfsave') {
    include '../lib/ControllerUser.php';
    $CONTROL = new ControllerUser();
    echo $CONTROL->getResponseJSON();
} else {
    echo 'OPERACION NO DISPONIBLE';
}
?>
