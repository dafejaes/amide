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
} else if($op == 'sucget' || $op == 'sucsave' || $op == 'sucdelete' || $op == 'suc2get'){
    include '../lib/ControllerBranchOffice.php';
    $CONTROL = new ControllerBranchOffice();
    echo $CONTROL->getResponseJSON();
} else if($op == 'asisget' || $op == 'asissave' || $op == 'asisdelete' || $op == 'depget' || $op == 'depsave' || $op== 'depdelete' || $op == 'serget' || $op=='sersave' || $op=='serdelete'){
    include '../lib/ControllerHealthcareArea.php';
    $CONTROL = new ControllerHealthcareArea();
    echo $CONTROL->getResponseJSON();
} else if($op == 'ubisave' || $op == 'ubiget'){
    include '../lib/ControllerLocation.php';
    $CONTROL = new ControllerLocation();
    echo $CONTROL->getResponseJSON();
} else if($op == 'tipoeqsave' || $op == 'tipoeqget' || $op == 'tipoeqdelete' || $op == 'partecget' || $op == 'partecsave' || $op=='partecdelete' || $op=='magcalisave' || $op=='magcaliget'){
    include '../lib/ControllerTypeEquipment.php';
    $CONTROL = new ControllerTypeEquipment();
    echo $CONTROL->getResponseJSON();
} else if($op == 'serget2'){
    include '../lib/ControllerService.php';
    $CONTROL = new ControllerService();
    echo $CONTROL->getResponseJSON();
} else if($op == 'eqsave' || $op == 'eqget'){
    include '../lib/ControllerEquipments.php';
    $CONTROL = new ControllerEquipments();
    echo $CONTROL->getResponseJSON();
}else if($op == 'conseget' || $op == 'recepsave' || $op == 'obsget'){
    include '../lib/ControllerEquipRecep.php';
    $CONTROL = new ControllerEquipRecep();
    echo $CONTROL->getResponseJSON();
}else{
    echo 'OPERACION NO DISPONIBLE';
}
?>
